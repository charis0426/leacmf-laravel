<?php

namespace App\Http\Controllers\Admin;

use App\Library\Y;
use Illuminate\Http\Request;
use App\Model\Node;
use App\Model\Version;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class NodeController extends Controller
{

    /*
     * 节点列表
     * @param Request $request
     * @return view/json
     */
    public function index(Request $request)
    {
        #判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->post();
            Log::debug($post);
            $validator = Validator::make($post, [
                'page'         => 'required|int',
                'page_size'    => 'required|int',
                'ip'           => 'ip',
                'status'       => 'int',
                'department_id'=> 'int|min:1'
            ], [], [
                'page'         => '页码',
                'page_size'    => '分页显示数量',
                'ip'           => 'IP地址',
                'status'       => '节点状态',
                'department_id'=> '组织机构'
            ]);
            if ($validator->fails()) {
                return Y::error($validator->errors());
            }
            $node = Node::leftjoin('departments','departments.id','=','nodes.department_id');
            if(isset($post['department_id']) && $post['department_id']!=""){
                #判断所选机构属性
                $res = $this->checkDepartment($post['department_id']);
                if($res == 1) {
                    #省查询省下面的地级市
                    $node = $node->where('departments.pid', $post['department_id']);
                }else if($res == 2){
                    #市级查看地级市的节点
                    $node = $node->where('nodes.department_id',$post['department_id']);
                }
            }
            if(isset($post['ip']) && $post['ip']!=""){
                $node = $node->where('nodes.ip','like','%'.$post['ip'].'%');
            }
            if(isset($post['status']) && $post['status']!=""){
                $node = $node->where('nodes.status','=',$post['status']);
            }
            try {
                $count = $node->count();
                $res = $node->select('nodes.*','departments.name')->offset(($post['page'] - 1) * $post['page_size'])
                    ->limit($post['page_size'])->get();
            }catch (\Exception $e){
                Log::error($e);
                return Y::error("查询异常");
            }
            $result=['data'=>$res,'current_page'=>$post['page'],'page_size'=>$post['page_size'],'total'=>$count];
            return Y::success("成功",$result);
        }else{
            return view('admin.node.index_list');
        }
    }

    /*
     * Show the form for creating a new resource.
     * 节点升级
     * @param Request $request
     * @return view or json
     */
    public function upgrade(Request $request)
    {
        #判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->post();
            Log::debug($post);
            $validator = Validator::make($post, [
                'file_path'  => 'required|string|unique:versions',
                'description'=> 'required|string'
            ],[],['file_path'=>'升级文件','description'=>'升级描述']);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            #按照规则获取升级文件版本号
            $path =substr($post['file_path'],strpos($post['file_path'],'_')+1);
            $path = substr($path,0,strpos($path, '.tar.gz'));
            if($path){
                $post['version'] = $path;
            }else{
                Log::error('获取升级文件版本号失败');
                return Y::error('获取升级文件版本号失败');
            }
            #升级文件信息写入数据库
            DB::beginTransaction();
            try {
                Version::create($post);
            } catch (\Exception $e) {
                Log::error($e);
                DB::rollBack();
                return Y::error('升级任务发起失败');
            }
            #调用底层接口通知节点升级
            $map['UpdateFileName'] = $post['file_path'];
            $res  = $this->request('POST','Upgrade/update',$map);
            if(!$res){
                DB::rollBack();
                Log::error('升级任务发起失败');
                return Y::error('升级任务发起失败');
            }
            DB::commit();
            Log::info('版本上传成功，等待升级');
            return Y::success('版本上传成功，等待升级');
            #回滚数据
        }else{
            return view('admin.node.create');
        }
    }

    /*
     * 获取历史版本列表
     * @param Request $request
     * @return view or json
     */
    public function history(Request $request)
    {
        #判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->post();
            Log::debug($post);
            $validator = Validator::make($post, [
                'page'         => 'required|int',
                'page_size'    => 'required|int',
                'start_time'   => 'string',
                'end_time'     => 'string',
                'description'  => 'string',
                'version'      => 'string'
            ], [], [
                'start_time'   => '开始时间',
                'end_time'     => '结束时间',
                'description'  => '描述',
                'version'      => '版本号',
                'page'         => '页码',
                'page_size'    => '分页显示数量'
            ]);
            if ($validator->fails()) {
                return Y::error($validator->errors());
            }
            $version = Version::orderBy("created_at","desc");
            if(isset($post['start_time']) && $post['start_time']!=""){
                $version = $version->where('created_at','>=',$post['start_time']);
            }
            if(isset($post['end_time']) && $post['end_time']!=""){
                $version = $version->where('created_at','<=',$post['end_time']);
            }
            if(isset($post['description']) && $post['description']!=""){
                $version = $version->where('description','like','%'.$post['description'].'%');
            }
            if(isset($post['version']) && $post['version']!=""){
                $version = $version->where('version','like','%'.$post['version'].'%');
            }
            try {
                $count = $version->count();
                $res = $version->offset(($post['page'] - 1) * $post['page_size'])
                    ->limit($post['page_size'])->get();
            }catch (\Exception $e){
                Log::error($e);
                return Y::error("查询异常");
            }
            $result=['data'=>$res,'current_page'=>$post['page'],'page_size'=>$post['page_size'],'total'=>$count];
            return Y::success("成功",$result);
        }else{
            return view('admin.node.version_list');
        }
    }

    /*
     * 回滚至上一个版本
     * @param  \Illuminate\Http\Request  $request
     * @return json
     */
    public function roleBack(Request $request)
    {
        #判断请求方式
        if ($request->isMethod('post')) {
            #判断是否有你可以回滚的版本
            try{
                $count = Version::count();
            }catch (\Exception $e){
                Log::error($e);
                return Y::error("服务异常");
            }
            if($count <= 1){
                return Y::error("当前没有可以回滚的版本");
            }
            #查询上一个版本号
            try{
                $res = Version::orderBy('created_at','desc')->offset(1)->limit(1)->get();
            }catch (\Exception $e){
                Log::error($e);
                return Y::error("服务异常");
            }
            if(!$res->count()){
                return Y::error("回滚版本失败");
            }
            #回滚命令发送
            $map['UpdateFileName'] = $res[0]['file_path'];
            $ret  = $this->request('POST','Upgrade/update',$map);
            if($ret){
                Log::info('回滚任务已发起');
                return Y::success('回滚任务已发起');
            }
            Log::error('回滚任务发起失败');
            return Y::error("回滚任务发起失败");
        }

    }

    /*
     * 查询当前版本信息
     * @param  \Illuminate\Http\Request  $request
     * @return json
     */
    public function versionInfo()
    {
        #查询当前版本
        try{
            $res = Version::orderBy('created_at','desc')->offset(0)->limit(1)->get();
        }catch (\Exception $e){
            Log::error($e);
            return Y::error("未查询到当前版本,请检查服务是否正常");
        }
        if(count($res) == 0){
            return Y::success("查询成功",['info'=>"",'progress'=>["total"=>1,"finish"=>1]]);
        }
        #查询当前版本升级进度
        try {
            $re = DB::table('nodes')
                ->select(DB::raw("count(*) as total , 
                count(versions='" . $res[0]['version'] . "' and progress='100' or null) as finish"))->get();
        }catch (\Exception $e){
            Log::error($e);
            return Y::error("未查询到当前节点升级进度,请检查服务是否正常");
        }
        return Y::success("查询成功",['info'=>$res[0],'progress'=>$re[0]]);
    }

    /*
     * 查询当前版本信息
     * @param  \Illuminate\Http\Request  $request
     * @return json
     */
    public function stopUpgrade()
    {
        #调用底层停止接口
        $map['NodeId'] = 0;
        $res  = $this->request('POST','Upgrade/stop',$map);
        if(!$res){
            return Y::error("停止升级失败");
        }
        return Y::success("停止升级成功");
    }

    /**
     * Update the specified resource in storage.
     * 查询节点资源使用情况
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function useResources($id)
    {
        //查询数据
        try {
            $record = Node::where('id',$id)->select('cpu_use', 'mem_use', 'disk_use')->first();
        }catch (\Exception $e){
            Log::error($e);
            return Y::error("查询异常");
        }
        return Y::success('查询成功', $record);

    }

    /*
     * ssh反向登录
     * @param  $Request
     * @return \Illuminate\Http\Response
     */
    public function nodeSsh(Request $request)
    {
        #判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->post();
            Log::debug($post);
            $validator = Validator::make($post, [
                'NodeId' => 'required|int'
            ], [], ['NodeId' => '节点id']);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            #发送请求向节点控制器
            $map['NodeId'] = (int)$post['NodeId'];
            $ret  = $this->request('POST','node/sshcmd',$map);
            if($ret){
                Log::info('节点ssh反向登录成功');
                return Y::success('任务成功');
            }
            return Y::error("任务失败");
        }
    }
}
