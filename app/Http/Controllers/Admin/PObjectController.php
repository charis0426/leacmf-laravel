<?php

namespace App\Http\Controllers\admin;

use App\Library\Help;
use App\Library\Y;
use App\Model\Brand;
use App\Model\Company;
use App\Model\Department;
use App\Model\Device;
use App\Model\Dot;
use App\Model\PCompany;
use App\Model\PObject;
use App\Model\Transportation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class PObjectController extends Controller
{
    /**
     * Display a listing of the resource.
     * //查看重点对象列表
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->post();
            //验证参数是否合法
            $validator = Validator::make($post, [
                'page_size' => 'required|integer',
                'page' => 'required|integer',
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            Log::debug($post);
            //获取当前用户部门id
            $group_id = Auth::guard('admin')->user()->group_id;
            //$group_id = 100;

            //获取分页
            $offset = Help::offset($post['page_size'], $post['page']);
            //查询数据
            $data = PObject::orderBy('id', 'DESC');
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
                    $data->whereIn('department_id', $id);
                }else{
                    $data->where('department_id', $department_id);
                }
            }
            //是否有name
            /*if ($request->has('name') && !empty($post['name'])){
                $data->where('name', 'LIKE', '%'.$post['name'].'%');
            }*/
            if ($request->has('id') && !empty($post['id'])){
                $data->where('id', $post['id']);
            }
            //是否有类型
            if($request->has('type') && !empty($post['type']) && $post['type'] != 0){
                $data->where('type', $post['type']);
            }

            //查询数据
            try {
                $count = $data->count();
                $res = $data->offset($offset)
                    ->limit($post['page_size'])->get();
            }catch (\Exception $e){
                Log::error($e);
                return Y::error("查询异常");
            }
            //print_r($res);
            $record = ['data'=>$res,'current_page'=>$post['page'],
                'page_size'=>$post['page_size'], 'count'=>$count];
            //print_r($record);
            Log::info($record);
            return Y::success('查询成功', $record);
        }else{
            return view('admin.point.index_list');
        }
    }

    /**
     * Show the form for creating a new resource.
     * 获取重点对象列表
     * @return \Illuminate\Http\Response
     */
    public function objectQuery(Request $request)
    {
        $post = $request->post();
        //验证参数是否合法
        $validator = Validator::make($post, [
            'type' => 'required:integer',
        ],[],['type'=>'对象类型']);
        if ($validator->fails()) {
            Log::error($validator->errors());
            return Y::error($validator->errors());
        }
        //获取当前用户部门id
        $group_id = Auth::guard('admin')->user()->group_id;
        //$department_id = 1;
        //查询数据
        $data = PObject::orderBy('id', 'DESC');
        if ($post['type'] !=0){
            $data->where('type', $post['type']);
        }
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
                $data->whereIn('department_id', $id);
            }else{
                $data->where('department_id', $department_id);
            }
        }
        //查询数据
        try {
            $res = $data->get()->mapWithKeys(function ($item) {
                return [$item['id'] => $item['name']];
            });
            Log::info($res);
        }catch (\Exception $e){
            Log::error($e);
            return Y::error("查询异常");
        }
        return Y::success('查询成功', $res);
    }

    public function objectList(Request $request)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            //获取当前用户部门id
            $group_id = Auth::guard('admin')->user()->group_id;
            //$group_id = 18;
            $post = $request->post();
            Log::debug($post);
            //验证参数是否合法
            $validator = Validator::make($post, [
                'type' => 'required:integer',
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            $ids = PObject::where('type', $post['type'])
                ->where('department_id', $group_id)->pluck('pid')->toarray();
            //查询数据
            if ($post['type'] == 1){
                $data = Company::whereNotIn('id', $ids);
            }elseif ($post['type'] == 2){
                $data = Transportation::whereNotIn('id', $ids);
            }else{
                $data = Dot::whereNotIn('id', $ids);
            }
            //不是国家级管理员
            if (Department::getPid($group_id) != 0){
                //获取下属所有子部门
                $id = Department::getIdByPid($group_id);
                //判断是否有下属子部门
                if(!empty($id)) {
                    $id[] = $group_id;
                    $data->whereIn('department_id', $id);
                }else{
                    $data->where('department_id', $group_id);
                }
            }
            $record = $data->get(['id', 'name'])->toarray();
            Log::info($record);
            return Y::success('查询成功', $record);
        }
    }

    /**
     * Show the form for creating a new resource.
     * 添加重点对象
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            //获取当前用户部门id
            $group_id = Auth::guard('admin')->user()->group_id;
            //$group_id = 5;
            $post = $request->post();
            Log::debug($post);
            //验证参数是否合法
            $validator = Validator::make($post,
                [
                    'id' => 'required:integer',
                    'type' => 'required:integer',
                ],
                [],
                ['id' => '对象名称', 'type' => '对象类型']
            );
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            $object = PObject::where('pid', $post['id'])->where('type', $post['type'])
                ->where('department_id', $group_id)->get();
            //判断数据是否存在
            if ($object->count()){
                return Y::error('重点对象已经存在');
            }
            //查询数据
            if ($post['type'] == 1){
                $res = Company::find($post['id'])->toarray();
            }elseif ($post['type'] == 2){
                $res = Transportation::find($post['id'])->toarray();
            }else{
                $res = Dot::find($post['id'])->toarray();
            }
            //组装写入数据
            $data['name'] = $res['name'];
            $data['type'] = $post['type'];
            $data['department_id'] = $group_id;
            $data['pid'] = $post['id'];
            $data['cause'] = $post['cause'];
            //数据写入
            try {
                PObject::create($data);
            } catch (\Exception $e) {
                Log::error($e);
                return Y::error('添加失败');
            }
            Log::info('添加重点对象"'. $data['name'] .'"' . '成功');
            return Y::success('添加成功');
        }else{
            return view('admin.point.add');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //查询数据
        $data = PObject::find($id)->toarray();
        $record = [];
        if ($data['type'] == 1){
            //查询数据
            $record = Company::findOrFail($data['pid'])->toarray();
            $brands = Brand::whereIn('id', explode(',', $record['brand_ids']))->pluck('name')->toarray();
            $record['brands'] = implode(',', $brands);
        }elseif ($data['type'] == 2){
            //查询数据
            $data = Transportation::where('supervision_transportations.id', $data['pid']);
            $data->leftJoin('supervision_companys', 'supervision_companys.id',
                '=', 'supervision_transportations.pid');
            $data->select('supervision_transportations.*', 'supervision_companys.name AS pname');
            //查询数据
            try {
                $record = $data->first()->toarray();
            }catch (\Exception $e){
                Log::error($e);
                return Y::error("查询异常");
            }
            $brands = Brand::whereIn('id', explode(',', $record['brand_ids']))->pluck('name')->toarray();
            $record['brands'] = implode(',', $brands);
        }elseif ($data['type'] == 3){
            //查询数据
            $data = Dot::where('supervision_dots.id', $data['pid']);
            $data->leftJoin('supervision_companys', 'supervision_companys.id',
                '=', 'supervision_dots.pid');
            $data->select('supervision_dots.*', 'supervision_companys.name AS pname');
            //查询数据
            try {
                $record = $data->first()->toarray();
            }catch (\Exception $e){
                Log::error($e);
                return Y::error("查询异常");
            }
            $brands = Brand::whereIn('id', explode(',', $record['brand_ids']))->pluck('name')->toarray();
            $record['brands'] = implode(',', $brands);
        }
        Log::info($record);
        //返回json
        return Y::success("查询成功",$record);
    }

    //共享企业
    public function share(Request $request)
    {
        $post = $request->post();
        Log::debug($post);
        //验证参数是否合法
        $validator = Validator::make($post, [
            'id' => 'exists:point_companys,id',
            'department_id' => 'exists:departments,id',
        ]);
        if ($validator->fails()) {
            Log::error($validator->errors());
            return Y::error($validator->errors());
        }
        //查询重点企业内容
        $record = PCompany::find($post['id']);
        $data['c_id'] = $record->c_id;
        $data['department_id'] = $post['department_id'];
        //判断数据是否存在
        $res = PCompany::where(['c_id'=>$data['c_id'], 'department_id'=>$data['department_id']])->get();
        //print_r($res);
        if (!$res->isEmpty()){
            Log::error('重点企业已经存在');
            return Y::error('重点企业已经存在');
        }
        //数据写入
        try {
            PCompany::create($data);
        } catch (\Exception $e) {
            Log::error($e);
            return Y::error('共享失败');
        }
        Log::info('共享重点企业"'. $post['id'] .'"' . '成功');
        return Y::success('共享成功');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * 删除重点对象
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //数据删除
        try {
            PObject::destroy($id);
            Log::info('删除成功');
            return Y::success('删除成功');
        } catch (\Exception $e) {
            Log::error($e);
            return Y::error('删除失败');
        }
    }
    /*
     * Batch remove the specified resource from storage.
     * 批量删除重点对象
     * @param  array  $ids
     * @return \Illuminate\Http\Response
     */
    public function batchDestroy(Request $request)
    {
        #判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->post();
            #验证参数是否合法
            $validator = Validator::make($post, [
                'ids' => 'required|array'
            ],  [],  [
                'ids' => '参数'
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            #判断数据长度是否为0
            if(count($post['ids']) == 0){
                return Y::error("删除对象为空");
            }
            #遍历删除数据，返回成功删除数
            $count = 0;
            foreach ($post['ids'] as $id){
                try {
                    PObject::destroy($id);
                    $count ++;
                } catch (\Exception $e) {
                    Log::error($e);
                }
            }
            return Y::success("删除成功",['count'=>$count]);
        }
        return Y::error("非法请求类型");
    }

    /*
     * Batch remove the specified resource from storage.
     * 查看重点对象下设备列表
     * @param  array  $ids
     * @return \Illuminate\Http\Response
     */
    public function device(Request $request)
    {
        #判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->post();
            //验证参数是否合法
            $validator = Validator::make($post, [
                'id' => 'exists:point_objects,id',
                'type' => 'required:integer',
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            $res = PObject::find($post['id']);
            //print_r($res);exit();
            //查询设备列表
            if ($post['type'] == 2){
                $record = Dot::find($res['pid'])->device()->where('type', 0)
                    ->get(['id', 'name', 'url'])->toarray();
            }elseif ($post['type'] == 3){
                $record = Transportation::find($res['pid'])->device()->where('type', 1)
                    ->get(['id', 'name', 'url'])->toarray();
            }
            return Y::success("查询成功",$record);
        }
    }

    /*
     * Batch remove the specified resource from storage.
     * 查看重点对象下设备列表
     * @param  array  $ids
     * @return \Illuminate\Http\Response
     */
    public function deviceList($id)
    {
        $data = PObject::find($id);
        if ($data->type == 2){
            $record = Device::where('type', 0)->where('dt_id', $data->pid)
                ->select('name','cameraid')->get();
        }elseif ($data->type == 3){
            $record = Device::where('type', 1)->where('dt_id', $data->pid)
                ->select('name','cameraid')->get();
        }else{
            $record = [];
        }
        return Y::success("查询成功",$record);
    }
}
