<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LogExport;
use App\Library\ArrayHelp;
use App\Library\Help;
use App\Model\Admin;
use App\Model\DLog;
use App\Model\Department;
use App\Library\Y;
use App\Model\FileLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Excel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     * 操作日志列表
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->post();
            Log::debug($post);
            //验证参数是否合法
            $validator = Validator::make($post, [
                'page_size' => 'required|integer',
                'page' => 'required|integer',
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            //组装sql语句
            $where = $this->assembleSql($post);
            //获取分页(缓存中取)
            $offset = Help::offset($post['page_size'], $post['page']);
            //查询数据
            $res = DLog::logList($where, 'logs', $post['page_size'], $offset);
            foreach ($res['data'] as &$item) {
                $department = Department::select('name')->find($item->department_id);
                $item->content = json_decode($item->content);
                $item->department = $department->name;
            }
            $record = ['data' => $res['data'], 'current_page' => $post['page'],
                'page_size' => $post['page_size'], 'count' => $res['total']];
            Log::debug($record);
            return Y::success('查询成功', $record);
        } else {

            return view('admin.log.index_list');
        }
    }

    /**
     * Display a listing of the resource.
     * 获取组织机构
     * @return \Illuminate\Http\Response
     */
    public function department()
    {
        //查询所有部门
        $res = Department::all()->toArray();
        $record = ArrayHelp::list_to_tree_select($res, 'id', 'pid', 'children', 0);
        //print_r($res);
//        return Y::success('查询成功', $record);
        return $record;
    }

    /**
     * Display a listing of the resource.
     * 获取日志类型
     * @return \Illuminate\Http\Response
     */
    public function logType()
    {
        $data = Permission::select('id', 'pid', 'title as name')->get()->toArray();
        $record = ArrayHelp::list_to_tree_select($data, 'id', 'pid', 'children', 0);
        //print_r($record);
        /*$record = Permission::all()->mapWithKeys(function ($item) {
            return [$item['id'] => $item['title']];
        });*/
//        return Y::success('查询成功', $record);
        return $record;
    }

    /**
     * Display a listing of the resource.
     * 获取操作人员
     * @return \Illuminate\Http\Response
     */
    public function logUser(Request $request)
    {
        $post = $request->post();
        if ($request->has('department_id') && !empty($post['department_id'])) {
            $department_id = $post['department_id'];
            $data = Admin::select('nickname');
            //不是国家级管理员
            if (Department::getPid($post['department_id']) != 0) {
                //获取下属所有子部门
                $id = Department::getIdByPid($department_id);
                //判断是否有下属子部门
                if (!empty($id)) {
                    $id[] = $department_id;
                    $data->whereIn('group_id', $id);
                } else {
                    $data->where('group_id', $department_id);
                }
            }
            $record = $data->get();
        } else {
            $record = Admin::select('nickname')->get();
        }
        return Y::success('查询成功', $record);
    }

    /**
     * Display a listing of the resource.
     * 系统日志列表
     * @return \Illuminate\Http\Response
     */
    public function operation(Request $request)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->post();
            Log::debug($post);
            //验证参数是否合法
            $validator = Validator::make($post, [
                'page_size' => 'required|integer',
                'page' => 'required|integer',
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            //获取分页(缓存中取)
            $offset = Help::offset($post['page_size'], $post['page']);
            $end = $offset + $post['page_size'];
            //print_r($end);
            $path = env('APP_LOG_PATH');
            if (!is_dir($path)) {
                Log::error('日志目录' . $path . '不存在');
                return Y::error('查询失败');
            }
            $data = array();
            $record = array();
            if ($request->has('start_time') && !empty($post['start_time'])) {
                $s_time = strtotime($post['start_time']);
            } else {
                $s_time = 0;
            }
            if ($request->has('end_time') && !empty($post['end_time'])) {
                $e_time = strtotime($post['end_time']);
            } else {
                $e_time = 0;
            }
            //打开目录
            if ($dh = @opendir($path)) {
                //读取
                $i = 0;
                while (($file = readdir($dh)) !== false) {
                    if ($file != '.' && $file != '..') {
                        $etime = filemtime($path . DIRECTORY_SEPARATOR . $file);
                        if ($s_time != 0 && $e_time != 0) {
                            if ($etime >= $s_time && $etime <= $e_time) {
                                if ($i >= $offset && $i < $end) {
                                    $data[] = $file;
                                }
                                $i++;
                            }
                        } else {
                            if ($i >= $offset && $i < $end) {
                                $data[] = $file;
                            }
                            $i++;
                        }
                        //print_r($s_time);

                    }
                }
                //关闭
                closedir($dh);
            } else {
                Log::error('日志目录' . $path . '打开失败');
                return Y::error('查询失败');
            }
            //print_r($data);
            $record['data'] = array_reverse($data);
            $record['current_page'] = $post['page'];
            $record['count'] = $i;
            $record['page_size'] = $post['page_size'];
            return Y::success('查询成功', $record);
        } else {
            return view('admin.log.index_list');
        }
    }

    /**
     * Display a listing of the resource.
     * 系统日志内容读取
     * @return \Illuminate\Http\Response
     */
    public function operationContent(Request $request)
    {
        $post = $request->post();
        Log::debug($post);
        //验证参数是否合法
        $validator = Validator::make($post, [
            'name' => 'required|max:255',
            'page'       => 'required|int',
            'page_size'  => 'required|int'
        ],[],
            [
                'name'       => '日志名称',
                'page'       => '页码',
                'page_size'  => '分页显示数量'
            ]);
        if ($validator->fails()) {
            Log::error($validator->errors());
            return Y::error($validator->errors());
        }
        $path = env('APP_LOG_PATH');
        if (!is_dir($path)) {
            Log::error('日志目录' . $path . '不存在');
            return Y::error('查询失败');
        }
        $file = $path . '/' . $post['name'];
        if (!is_file($file)) {
            Log::error('日志文件' . $file . '不存在');
            return Y::error('查询失败');
        }
        $file_arr = file($file);
        $count = count($file_arr);
        //获取分页
        $offset = Help::offset($post['page_size'], $post['page']);
        $str = array();
        for($i=$offset; $i<$count; $i++){
            if ($i < ($offset+$post['page_size'])){
                $str[] = $file_arr[$i];
            }else{
              break;
            }
        }
        $data = json_decode(str_replace('\n', '', json_encode($str)));
        //print_r($data);
        $record = ['data'=>$data,'current_page'=>$post['page'],
            'page_size'=>$post['page_size'],'total'=>$count];
        return Y::success('查询成功', $record);
    }

    /**
     * Display a listing of the resource.
     * 归档日志列表
     * @return \Illuminate\Http\Response
     */
    public function fileList(Request $request)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->post();
            Log::debug($post);
            //验证参数是否合法
            $validator = Validator::make($post, [
                'page_size' => 'required|integer',
                'page' => 'required|integer',
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }

            //查询数据
            $data = FileLog::orderBy('id', 'DESC');
            if ($request->has('start_time') && !empty($post['start_time'])) {
                $data->where('created_at', '>=', $post['start_time']);
            }
            if ($request->has('end_time') && !empty($post['end_time'])) {
                $data->where('created_at', '<=', $post['end_time']);
            }
            //获取分页
            $offset = Help::offset($post['page_size'], $post['page']);
            //查询数据
            try {
                $res = $data->offset($offset)
                    ->limit($post['page_size'])->get();
                $count = $data->count();
            } catch (\Exception $e) {
                Log::error($e);
                return Y::error("查询异常");
            }
            $record = ['data' => $res, 'current_page' => $post['page'],
                'page_size' => $post['page_size'], 'count' => $count];
            Log::info($record);
            return Y::success('查询成功', $record);
        } else {
            return view('admin.log.file_list');
        }
    }

    /**
     * Display a listing of the resource.
     * 日志归档
     * @return \Illuminate\Http\Response
     */
    public function file(Request $request)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->post();
            Log::debug($post);
            //验证参数是否合法
            $validator = Validator::make($post, [
                'time' => 'required|date_format:Y-m-d',
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            //获取第一条记录创建时间
            $first = DLog::first()->toarray();
            $d_at = $first['created_at'];
            //组装文件名
            $start = date('Ymd', strtotime($d_at));
            $end = date('Ymd', strtotime($post['time']));
            $name = 'file_' . $start . '_' . $end . '_' . time();
            //组装文件地址
            $path = env('APP_FILE_PATH') . '/' . $name;
            //查询数据
            $end_time = $post['time'] . ' 23:59:59';
            $data = DLog::where('created_at', '<=', $end_time)->get();
            //数据写入
            try {
                file_put_contents($path, json_encode($data));
                $file_log['name'] = $name;
                $file_log['file'] = $path;
                FileLog::create($file_log);
                DLog::where('created_at', '<=', $end_time)->delete();
            } catch (\Exception $e) {
                Log::error($e);
                return Y::error("日志归档失败");
            }
            return Y::success('日志归档成功');
        }
    }

    //归档日志激活
    public function activation($id)
    {
        //查询内容
        $record = FileLog::find($id)->toarray();
        if (!$record) {
            Log::error($id . '对应数据库信息不存在');
            return Y::error('激活失败');
        }

        //检查文件是否存在
        if (!file_exists($record['file'])) {
            Log::error($id . '对应归档文件不存在');
            return Y::error('激活失败');
        }
        //判断数据表是否存在
        if (Schema::hasTable($record['name']) && $record['status'] == 0) {
            FileLog::where('id', $id)->update(['status' => 1]);
            return Y::success('激活成功');
        }

        //创建数据表
        if (!DLog::createTable($record['name'])) {
            Log::error($id . '数据表创建失败');
            return Y::error('激活失败');
        }

        //读取数据内容转为数组
        $data = json_decode(file_get_contents($record['file']), true);
        $res = array_chunk($data, 500);
        //print_r($a);
        //Schema::dropIfExists($record['name']);
        //数据写入
        try {
            foreach ($res as $k => $v) {
                DLog::createData($record['name'], $v);
            }
            FileLog::where('id', $id)->update(['status' => 1]);
        } catch (\Exception $e) {
            Log::error($e);
            Schema::dropIfExists($record['name']);
            return Y::error('激活失败');
        }
        Log::info('归档数据写入成功');
        return Y::success('激活成功');
    }

    //激活日志删除
    public function delete($id)
    {
        //查询内容
        $record = FileLog::find($id)->toarray();
        if (!$record) {
            Log::error($id . '对应数据库信息不存在');
            return Y::error('删除失败');
        }
        if (Schema::hasTable($record['name'])) {
            //尝试删除数据
            try {
                Schema::dropIfExists($record['name']);
            } catch (\Exception $e) {
                Log::error($e);
                return Y::error('删除失败');
            }
        }
        FileLog::where('id', $id)->update(['status' => 0]);
        return Y::success('删除成功');

    }

    //归档日志内容查询
    public function content(Request $request)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->post();
            Log::debug($post);
            //验证参数是否合法
            $validator = Validator::make($post, [
                'page_size' => 'required|integer',
                'page' => 'required|integer',
                'id' => 'exists:file_logs,id',
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            //查询归档数据
            $file_logs = FileLog::find($post['id']);
            //print_r($file_logs);exit();
            //组装sql语句
            $where = $this->assembleSql($post);
            //获取分页(缓存中取)
            $offset = Help::offset($post['page_size'], $post['page']);
            //查询数据
            $res = DLog::logList($where, $file_logs['name'], $post['page_size'], $offset);
            foreach ($res['data'] as &$item) {
                $department = Department::select('name')->find($item->department_id);
                $item->content = json_decode($item->content);
                $item->department = $department->name;
            }
            $record = ['data' => $res['data'], 'current_page' => $post['page'],
                'page_size' => $post['page_size'], 'count' => $res['total']];
            Log::debug($record);
            return Y::success('查询成功', $record);
        } else {
            return view('admin.log.content_list');
        }
    }


    /**
     * Store a newly created resource in storage.
     * //日志导出
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        if ($request->isMethod('post')) {
            $post = $request->post();
            Log::debug($post);
            $data = DLog::orderBy('id', 'DESC');
            $group_id = Auth::guard('admin')->user()->group_id;
            //$group_id = 1;
            //判断是否有部门
            if ($request->has('department_id') && !empty($post['department_id'])){
                $department_id = $post['department_id'];
            }else{
                $department_id = $group_id;
            }
            //不是国家级管理员
            if (Department::getPid($department_id) != 0){
                //获取下属所有子部门
                $id = Department::getIdByPid($department_id);
                //判断是否有下属子部门
                if(!empty($id)) {
                    $id[] = $department_id;
                    $data->whereIn('supervision_transportations.department_id', $id);
                }else{
                    $data->where('supervision_transportations.department_id', $department_id);
                }
            }
            if ($request->has('name') && !empty($post['name'])) {
                $data->where('nick_name', $post['name']);
            }
            if ($request->has('type') && !empty($post['type'])) {
                $data->where('type', 'LIKE', '%' . $post['type'] . '%');
            }
            if ($request->has('start_time') && !empty($post['start_time'])) {
                $data->where('created_at', '>=', $post['start_time']);
            }
            if ($request->has('end_time') && !empty($post['end_time'])) {
                $data->where('created_at', '<=', $post['end_time']);
            }
            $data->leftJoin('departments', 'departments.id', '=', 'logs.department_id');
            $data->select('logs.id', 'departments.name AS name', 'logs.type', 'logs.content', 'logs.nick_name',
                'logs.ip', 'logs.method', 'logs.created_at');
            //print_r($data->toSql());die;
            $res = $data->get();
            //print_r($res->toArray());
            //$where = $this->assembleSql($post);
            //$data = DLog::logDown($where, 'logs');
            $title = 'log_' . date('Ymdhi') . '.xlsx';
            /*print_r($res);
            exit();*/
            return Excel::download(new LogExport($res), $title);
        } else {
            return view('admin.log.export');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    private function assembleSql($post)
    {
        $where = '1=1 ';
        //获取当前用户部门id
        $group_id = Auth::guard('admin')->user()->group_id;
        //$group_id = 1;

        //判断是否有部门
        if (isset($post['department_id']) && !empty($post['department_id'])) {
            $department_id = $post['department_id'];
        } else {
            $department_id = $group_id;
        }
        //不是国家级管理员
        if (Department::getPid($department_id) != 0) {
            //获取下属所有子部门
            $id = Department::getIdByPid($department_id);
            //判断是否有下属子部门
            if (!empty($id)) {
                $id[] = $department_id;
                $ids = implode(',', $id);
                $where .= ' AND department_id IN (' . $ids . ')';
            } else {
                $where .= ' AND department_id = ' . $department_id;
            }
        }

        if ($post) {
            if (isset($post['name']) && !empty($post['name'])) {
                $where .= " AND nick_name = '" . $post['name'] . "'";
            }
            if (isset($post['type']) && !empty($post['type'])) {
                $where .= " AND type = '" . $post['type'] . "'";
            }
            if (isset($post['start_time']) && !empty($post['start_time'])) {
                $where .= " AND created_at >= '" . $post['start_time'] . "'";
            }
            if (isset($post['end_time']) && !empty($post['end_time'])) {
                $where .= " AND created_at <= '" . $post['end_time'] . "'";
            }
        }
        return $where;
    }


}
