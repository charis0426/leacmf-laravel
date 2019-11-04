<?php

namespace App\Http\Controllers\Admin;

use App\Library\Help;
use App\Library\Y;
use App\Model\Brand;
use App\Model\Company;
use App\Model\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     * 显示监管品牌列表
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //获取当前用户部门id
        $group_id = Auth::guard('admin')->user()->group_id;
        //判断请求方式
        if ($request->isMethod('post')) {
            //$department_id = 14;
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

            //获取分页
            $offset = Help::offset($post['page_size'], $post['page']);

            //查询数据
            $data = Brand::orderBy('id', 'DESC');
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
                    $data->whereIn('supervision_brands.department_id', $id);
                }else{
                    $data->where('supervision_brands.department_id', $department_id);
                }
            }
            //是否有name
            if ($request->has('name') && !empty($post['name'])){
                $data->where('supervision_brands.name', 'LIKE', '%'.$post['name'].'%');
            }
            //是否有企业
            if($request->has('id') && !empty($post['id'])){
                $data->where('supervision_brands.pid', $post['id']);
            }
            $data->leftJoin('supervision_companys', 'supervision_companys.id',
                '=', 'supervision_brands.pid');
            $data->select('supervision_brands.*', 'supervision_companys.name AS pname');
            //查询数据
            try {
                $count = $data->count();
                $res = $data->offset($offset)
                    ->limit($post['page_size'])->get();
            }catch (\Exception $e){
                Log::error($e);
                return Y::error("查询异常");
            }
            $record = ['data'=>$res,'current_page'=>$post['page'],
                'page_size'=>$post['page_size'], 'count'=>$count];
            Log::debug($record);
            return Y::success('查询成功', $record);
        }else{
            $data = Company::orderBy('id', 'DESC');
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
            $record = $data->get()->toArray();
            return view('admin.brand.index_list', [
                'record'    => $record,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     * 添加监管品牌
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->post();
            Log::debug($post);
            //验证参数是否合法
            $validator = Validator::make($post, [
                'name' => 'required|unique:supervision_brands|max:100',
                'company' => 'required|max:255',
                'shorthand' => 'required|unique:supervision_brands|max:64',
                'trademark' => 'required|max:255',
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            //数据写入
            try {
                Brand::create($post);
            } catch (\Exception $e) {
                Log::error($e);
                return Y::error('添加失败');
            }
            Log::info('添加品牌"'. $post['name'] .'"' . '成功');
            return Y::success('添加成功');
        }else{
            return view('admin.supervision.brand.add');
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
     * 显示详细信息
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //查询数据
        $data = Brand::where('supervision_brands.id', $id);
        $data->leftJoin('supervision_companys', 'supervision_companys.id',
            '=', 'supervision_brands.pid');
        $data->select('supervision_brands.*', 'supervision_companys.name AS pname');
        //查询数据
        try {
            $record = $data->first()->toarray();
        }catch (\Exception $e){
            Log::error($e);
            return Y::error("查询异常");
        }
        Log::debug($record);
        //返回模板和信息
        return view('admin.brand.details', [
            'info'     => $record,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        $brand = Brand::find($id);
        $brand->status = $post['status'];
        //修改数据
        if ($brand->save()) {
            Log::info('修改品牌状态"'. $brand->name .'"' . '成功');
            return Y::success('更新成功');
        }
        Log::error('修改品牌状态"'. $brand->name .'"' . '失败');
        return Y::error('更新失败');
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
        //判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->all();
            Log::debug($post);
            //验证参数是否合法
            $validator = Validator::make($post, [
                'name' => 'required|max:50',
                'company' => 'required|max:255',
                'shorthand' => 'required|max:64',
                'trademark' => 'required|max:255',
                'status' => 'required|between:0,1'
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            $brand = Brand::find($id);
            //修改数据
            if ($brand->update($post)) {
                Log::info('修改品牌"'. $post['name'] .'"' . '成功');
                return Y::success('更新成功');
            }
            Log::error('修改品牌"'. $post['name'] .'"' . '失败');
            return Y::error('更新失败');
        }else{
            $record = Brand::findOrFail($id);
            Log::debug($record);
            return view('admin.supervision.brand.edit', [
                'info'     => $record,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * 删除品牌
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //数据删除
        try {
            Brand::destroy($id);
            Log::info('删除成功');
            return Y::success('删除成功');
        } catch (\Exception $e) {
            Log::error($e);
            return Y::error('删除失败');
        }
    }
}
