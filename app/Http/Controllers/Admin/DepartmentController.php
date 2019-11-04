<?php

namespace App\Http\Controllers\Admin;

use App\Imports\DepartmentImport;
use App\Library\ArrayHelp;
use App\Library\Tree;
use App\Model\Department;
use App\Library\Y;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Excel;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->log = new LogController();
    }

    /**
     * Display a listing of the resource.
     * 部门列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            $record = $this->tree();
            Log::debug($record);
            return Y::success('查询成功', $record);
        } else {
            return view('admin.institution.index_list');
        }
    }

    /**
     * Display a listing of the resource.
     * 部门govcoe
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function govcode()
    {
        //获取当前用户部门id
        $department_id = Auth::guard('admin')->user()->group_id;
        $record = Department::select('id','govcode')->where('id', $department_id)->first();
        Log::debug($record);
        return Y::success('查询成功', $record);

    }

    public function getIdByGovcode($govcode)
    {
        $data = Department::where('govcode','like', $govcode.'%')->get();
        if ($data->count()) {
            return Y::success('查询成功', $data[0]->id);
        }else{
            return Y::error('数据不存在');
        }
    }

    //获取部门树结构
    public function tree()
    {
        //获取当前用户部门id
        $department_id = Auth::guard('admin')->user()->group_id;
        $role_id = Auth::guard('admin')->user()->roles[0]->id;
        //$department_id = 1;
        //缓存key
        $key = 'tree_' . $department_id;
        //判断缓存是否存在
        if (Cache::has($key)) {
            //返回缓存内容
            return Cache::get($key);
        }
        //查询当前部门下属子部门
        if (Department::getPid($department_id) == 0 || $role_id == 1) {
            //查询所有部门
            $record = Department::all()->toArray();
            //print_r($record);
            //$res = Tree::unlimitForLayer($record, 0, 'children');
            $res = ArrayHelp::list_to_tree($record, 'id', 'pid', 'children', 0);
        } else {
            //查询当前id部门信息
            $res = Department::where('id', $department_id)->get()->toarray();
            //查询当前id下子部门信息
            $record = Department::where('pid', $department_id)->get()->toarray();
            $res[0]['children'] = $record;
        }
        //print_r(json_encode($res));exit();
        //缓存存储时间
        $expiresAt = now()->addMinutes(30);
        //树形结构写入缓存
        Cache::put($key, $res, $expiresAt);
        return $res;

    }


    /**
     * Show the form for creating a new resource.
     * 添加部门
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            //获取当前用户部门id
            $department_id = Auth::guard('admin')->user()->group_id;
            $post = $request->post();
            Log::debug($post);
            //验证参数是否合法
            $validator = Validator::make($post, [
                'name' => 'required|max:64',
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            $post['pid'] = $department_id;
            //数据写入
            try {
                Department::create($post);
            } catch (\Exception $e) {
                Log::error($e);
                return Y::error('添加失败');
            }
            Log::info('添加部门"' . $post['name'] . '"' . '成功');
            return Y::success('添加成功');
        } else {
            return view('admin.department.add');
        }
    }


    /**
     * Update the specified resource in storage.
     * 修改部门
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->only('name');
            Log::debug($post);
            //验证参数是否合法
            $validator = Validator::make($post, [
                'name' => 'required|max:64',
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            $department = Department::find($id);
            //修改数据
            if ($department->update($post)) {
                Log::info('修改部门"' . $post['name'] . '"' . '成功');
                return Y::success('更新成功');
            }
            Log::error('修改部门"' . $post['name'] . '"' . '失败');
            return Y::success('更新失败');
        } else {
            $record = Department::findOrFail($id);
            Log::debug($record);
            return view('admin.department.edit', [
                'admin' => $record,
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     * 删除部门
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //判断当前部门是否下属子部门
        if (1 == 1) {
            Log::error('该部门有下属子部门，无法删除');
            return Y::error('该部门有下属子部门，无法删除');
        }
        //判断当前部门下是否有企业
        if (1 == 1) {
            Log::error('该部门有下属企业，无法删除');
            return Y::error('该部门有下属企业，无法删除');
        }
        $post = Department::find($id);
        if (Department::destroy($id) > 0) {
            Log::info('删除部门"' . $post['name'] . '"' . '成功');
            return Y::success('删除成功');
        }
        Log::error('删除部门"' . $post['name'] . '"' . '失败');
        return Y::error('删除失败');
    }

    public function import()
    {
        $file = '/var/www/html/123.xls';
        Excel::import(new DepartmentImport($file), $file);
    }
}
