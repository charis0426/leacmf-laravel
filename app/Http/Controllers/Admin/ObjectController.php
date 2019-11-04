<?php

namespace App\Http\Controllers\Admin;

use App\Library\Help;
use App\Library\Y;
use App\Model\Department;
use App\Model\SObject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class ObjectController extends Controller
{
    /**
     * Display a listing of the resource.
     * 显示监管对象列表
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
            //$department_id = Auth::guard('admin')->user()->group_id;
            $department_id = 1;
            Log::debug($post);

            //获取分页
            $offset = Help::offset($post['page_size'], $post['page']);
            //查询数据
            $data = SObject::orderBy('id', 'DESC');
            if ($request->has('department_id') && !empty($post['department_id'])){
                $data->where('department_id', $post['department_id']);
            }else{
                //不是国家级管理员
                if (Department::getPid($department_id) != 0){
                    //获取下属所有子部门
                    $id = Department::getIdByPid($department_id);
                    $id[] = $department_id;
                    $data->whereIn('department_id', $id);
                }
            }
            if ($request->has('name') && !empty($post['name'])){
                $data->where('name', 'LIKE', '%'.$post['name'].'%');
            }
            //查询数据
            try {
                $res = $data->offset($offset)
                    ->limit($post['page_size'])->get();
                $count = $data->count();
            }catch (\Exception $e){
                Log::error($e);
                return Y::error("查询异常");
            }
            $record = ['data'=>$res,'current_page'=>$post['page'],
                'page_size'=>$post['page_size'], 'count'=>$count];
            Log::info($record);
            return Y::success('查询成功', $record);
        }else{
            return view('admin.supervision.company.index_list');
        }
    }
}
