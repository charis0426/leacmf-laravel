<?php

namespace App\Http\Controllers\Admin;

use App\Library\Help;
use App\Library\Y;
use App\Model\Brand;
use App\Model\Department;
use App\Model\Dot;
use App\Model\Node;
use App\Model\Transportation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class TransportationController extends Controller
{
    /**
     * Display a listing of the resource.
     * 查询监管转运中心列表
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            //获取当前用户部门id
            $group_id = Auth::guard('admin')->user()->group_id;
            //$department_id = 1;
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
            $data = Transportation::orderBy('id', 'DESC');
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
            //是否有企业
            if($request->has('id') && !empty($post['id'])){
                $data->where('supervision_transportations.pid', $post['id']);
            }
            //联合查询
            $data->leftJoin('supervision_companys', 'supervision_companys.id',
                '=', 'supervision_transportations.pid');
            $data->select('supervision_transportations.*', 'supervision_companys.name AS pname');
            //获取分页
            $offset = Help::offset($post['page_size'], $post['page']);
            //查询数据
            try {
                $count = $data->count();
                $res = $data->offset($offset)
                    ->limit($post['page_size'])->get();
            }catch (\Exception $e){
                Log::error($e);
                return Y::error("查询异常");
            }
            //组装数据
            $record = ['data'=>$res,'current_page'=>$post['page'],
                'page_size'=>$post['page_size'], 'count'=>$count];
            Log::debug($record);
            return Y::success('查询成功', $record);
        }else{
            return view('admin.transportation.index_list');
        }
    }

    /**
     * Show the form for creating a new resource.
     * 获取监管转运中心列表
     * @return \Illuminate\Http\Response
     */
    public function TransportationList(Request $request)
    {
        //获取当前用户部门id
        $group_id = Auth::guard('admin')->user()->group_id;
        //$department_id = 1;
        $post = $request->post();
        Log::debug($post);
        //查询数据
        $data = Transportation::orderBy('id', 'DESC');
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

    /**
     * Show the form for creating a new resource.
     * 获取监管转运中心列表
     * @return \Illuminate\Http\Response
     */
    public function TransportationListByUser(Request $request)
    {
        //获取当前用户部门id
        $group_id = Auth::guard('admin')->user()->group_id;
        //$group_id = 167;
        $post = $request->post();
        Log::debug($post);
        //查询数据
        $data = Transportation::orderBy('supervision_transportations.id', 'DESC');
        $dot = Dot::orderBy('supervision_dots.id', 'DESC');
        //判断是否有部门
        if ($request->has('department_id') && !empty($post['department_id'])){
            //print_r('aaaa');
            $department_id = $post['department_id'];
        }else{
            $department_id = $group_id;
        }
        //判断是否有部门
        if ($request->has('type') && !empty($post['type']) && $post['type'] == 1){
            if (Department::getPid($department_id) != 0) {
                //获取下属所有子部门
                $id = Department::getIdByPid($department_id);
                //判断是否有下属子部门
                if (!empty($id)) {
                    $ids = Node::whereIn('department_id', $id)->select(DB::raw('DISTINCT department_id'))->get();
                    $data->whereIn('supervision_transportations.department_id', $ids);
                    $dot->whereIn('supervision_dots.department_id', $ids);
                } else {
                    $ids = Node::where('department_id', $department_id)->select(DB::raw('DISTINCT department_id'))->get();
                    //print_r($ids);
                    $data->whereIn('supervision_transportations.department_id', $ids);
                    $dot->whereIn('supervision_dots.department_id', $ids);
                }
            }else{
                $ids = Node::select(DB::raw('DISTINCT department_id'))->get();
                //print_r($ids->toArray());
                $data->whereIn('supervision_transportations.department_id', $ids);
                $dot->whereIn('supervision_dots.department_id', $ids);
            }

        }else {
            //print_r($department_id);
            //不是国家级管理员
            if (Department::getPid($department_id) != 0) {
                //获取下属所有子部门
                $id = Department::getIdByPid($department_id);
                //判断是否有下属子部门
                if (!empty($id)) {
                    $id[] = $department_id;
                    $data->whereIn('supervision_transportations.department_id', $id);
                    $dot->whereIn('supervision_dots.department_id', $id);
                } else {
                    $data->where('supervision_transportations.department_id', $department_id);
                    $dot->where('supervision_dots.department_id', $department_id);
                }
            }
        }
        $data->leftJoin('departments', 'departments.id',
            '=', 'supervision_transportations.department_id');
        $dot->leftJoin('departments', 'departments.id',
            '=', 'supervision_dots.department_id');
        $data->select('supervision_transportations.id','supervision_transportations.name',
            'supervision_transportations.lat','supervision_transportations.lnt','departments.name AS dname');
        $dot->select('supervision_dots.id','supervision_dots.name',
            'supervision_dots.lat','supervision_dots.lnt','departments.name AS dname');
        //查询数据
        try {
            $restran = $data->get()->map(function ($item) {
                return ['id' => $item['id'],'name' => $item['name'],
                    'lat' => $item['lat'],'lnt' => $item['lnt'],'dname' => $item['dname'],'type' => 0];
            })->toArray();
            $resdot = $dot->get()->map(function ($item) {
                return ['id' => $item['id'],'name' => $item['name'],
                    'lat' => $item['lat'],'lnt' => $item['lnt'],'dname' => $item['dname'],'type' => 1];
            })->toArray();
            $res = array_merge($restran, $resdot);
            Log::info($res);
        }catch (\Exception $e){
            Log::error($e);
            return Y::error("查询异常");
        }
        return Y::success('查询成功', $res);
    }

    /**
     * Show the form for creating a new resource.
     * 添加监管转运中心
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            //获取当前用户部门id
            $department_id = Auth::guard('admin')->user()->group_id;
            //$department_id = 5;
            $post = $request->post();
            Log::debug($post);
            //验证参数是否合法
            $validator = Validator::make($post, [
                'name' => 'required|unique:supervision_transportations|max:50',
                'position' => 'required|max:255',
                'head' => 'required|max:20',
                'phone' => 'regex:/^1[345789][0-9]{9}$/',
                'licenses' => 'required|max:255',
                'brand_ids' => 'required',
                'pid' => 'required|integer',
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            $post['department_id'] = $department_id;
            //数据写入
            try {
                Transportation::create($post);
            } catch (\Exception $e) {
                Log::error($e);
                return Y::error('添加失败');
            }
            Log::info('添加转运中心"'. $post['name'] .'"' . '成功');
            return Y::success('添加成功');
        }else{
            $brand = Brand::getBrand();
            return view('admin.supervision.transportation.add', [
                'brand'    => $brand,
            ]);
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
        $data = Transportation::where('supervision_transportations.id', $id);
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
        Log::debug($record);
        //返回json
        return Y::success("查询成功",$record);
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
     * 修改转运中心信息
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->all();
            Log::debug($post);
            //验证参数是否合法
            $validator = Validator::make($post, [
                'name' => 'required|max:50',
                'position' => 'required|max:255',
                'head' => 'required|max:20',
                'phone' => 'regex:/^1[34578][0-9]{9}$/',
                'licenses' => 'required|max:255',
                'brand_ids' => 'required',
                'status' => 'required|between:0,1'
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            $transportation = Transportation::find($id);
            //修改数据
            if ($transportation->update($post)) {
                Log::info('修改监管转运中心"'. $post['name'] .'"' . '成功');
                return Y::success('更新成功');
            }
            Log::error('修改监管转运中心"'. $post['name'] .'"' . '失败');
            return Y::success('更新失败');
        }else{
            $record = Transportation::findOrFail($id);
            $brand = Brand::getBrand();
            Log::debug($record);
            return view('admin.supervision.transportation.edit', [
                'info'     => $record,
                'brand'    => $brand,
            ]);
        }
    }

    //更改转运中心状态
    public function status(Request $request, $id)
    {
        $post = $request->all();
        Log::debug($post);
        //验证参数是否合法
        $validator = Validator::make($post, [
            'status' => 'required|between:0,1'
        ]);
        if ($validator->fails()) {
            Log::error($validator->errors());
            return Y::error($validator->errors());
        }
        $transportation = Transportation::find($id);
        $transportation->status = $post['status'];
        //修改数据
        if ($transportation->save()) {
            Log::info('修改监管转运中心状态"'. $post['name'] .'"' . '成功');
            return Y::success('更新成功');
        }
        Log::error('修改监管转运中心状态"'. $post['name'] .'"' . '失败');
        return Y::success('更新失败');
    }

    //查看转运中心下设备列表
    public function device($id)
    {
        //查询数据
        $record = Transportation::find($id)->device()->where('type', 0)
            ->get(['id', 'name', 'cameraid'])->toarray();
        //print_r($record);exit();
        Log::info($record);
        return Y::success('查询成功', $record);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //判断当前转运中心下是否有设备
        $record = Dot::find($id)->device()->where('type', 0)->get();
        if(!$record->isEmpty()){
            Log::error('该转运中心下有设备，无法删除');
            return Y::error('该转运中心下有设备，无法删除');
        }
        //数据删除
        try {
            Transportation::destroy($id);
            Log::info('删除成功');
            return Y::success('删除成功');
        } catch (\Exception $e) {
            Log::error($e);
            return Y::error('删除失败');
        }
    }
    


}
