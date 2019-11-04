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

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     * 显示监管企业列表
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
            //获取当前用户部门id
            $group_id = Auth::guard('admin')->user()->group_id;
            //$group_id = 1;
            Log::debug($post);

            //获取分页
            $offset = Help::offset($post['page_size'], $post['page']);
            //查询数据
            $data = Company::orderBy('id', 'DESC');
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
            //判断是否有name
            if ($request->has('name') && !empty($post['name'])){
                $data->where('name', 'LIKE', '%'.$post['name'].'%');
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
            $record = ['data'=>$res,'current_page'=>$post['page'],
                'page_size'=>$post['page_size'], 'count'=>$count];
            Log::info($record);
            return Y::success('查询成功', $record);
        }else{
            return view('admin.company.index_list');
        }
    }

    /**
     * Show the form for creating a new resource.
     * 获取监管企业列表
     * @return \Illuminate\Http\Response
     */
    public function Company_list(Request $request)
    {
        //获取当前用户部门id
        $group_id = Auth::guard('admin')->user()->group_id;
        //$department_id = 1;
        //查询数据
        $data = Company::orderBy('id', 'DESC');
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
     * 添加监管企业
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
                'name' => 'required|unique:supervision_companys|max:50',
                'position' => 'required|max:255',
                'head' => 'required|max:20',
                'phone' => 'regex:/^1[345789][0-9]{9}$/',
                'licenses' => 'required|max:255',
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            $post['department_id'] = $department_id;
            //数据写入
            try {
                Company::create($post);
            } catch (\Exception $e) {
                Log::error($e);
                return Y::error('添加失败');
            }
            Log::info('添加企业"'. $post['name'] .'"' . '成功');
            return Y::success('添加成功');
        }else{
            return view('admin.supervision.company.add');
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
        $record = Company::findOrFail($id)->toarray();
        $brands = Brand::whereIn('id', explode(',', $record['brand_ids']))->pluck('name')->toarray();
        $record['brands'] = implode(',', $brands);
        Log::debug($record);
        //返回json
        return Y::success('查询成功',$record);

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
        $company = Company::find($id);
        $company->status = $post['status'];
        //修改数据
        if ($company->save()) {
            Log::info('修改监管企业状态"'. $company->name .'"' . '成功');
            return Y::success('更新成功');
        }
        Log::error('修改监管企业状态"'. $company->name .'"' . '失败');
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
                'position' => 'required|max:255',
                'head' => 'required|max:20',
                'phone' => 'regex:/^1[34578][0-9]{9}$/',
                'licenses' => 'required|max:255',
                'status' => 'required|between:0,1'
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            $company = Company::find($id);
            //修改数据
            if ($company->update($post)) {
                Log::info('修改监管企业"'. $post['name'] .'"' . '成功');
                return Y::success('更新成功');
            }
            Log::error('修改监管企业"'. $post['name'] .'"' . '失败');
            return Y::error('更新失败');
        }else{
            $record = Company::findOrFail($id);
            Log::debug($record);
            return view('admin.supervision.company.edit', [
                'info'     => $record,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * 删除企业
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //判断当前企业下是否有转运中心
        $transportation = Company::find($id)->transportation;
        if($transportation){
            Log::error('该企业下有转运中心，无法删除');
            return Y::error('该企业下有转运中心，无法删除');
        }
        //判断当前企业下是否有网点
        $dot = Company::find($id)->dot;
        if($dot){
            Log::error('该企业下有网点，无法删除');
            return Y::error('该企业下有网点，无法删除');
        }
        //数据删除
        try {
            Company::destroy($id);
            Log::info('删除成功');
            return Y::success('删除成功');
        } catch (\Exception $e) {
            Log::error($e);
            return Y::error('删除失败');
        }
    }
}
