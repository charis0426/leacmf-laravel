<?php

namespace App\Http\Controllers\Admin;

use App\Library\Help;
use App\Library\Y;
use App\Model\Brand;
use App\Model\Company;
use App\Model\Department;
use App\Model\Device;
use App\Model\Dot;
use App\Model\IeventModel;
use App\Model\Transportation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class ManualController extends Controller
{
    /**
     * Display a listing of the resource.
     * 显示人工巡检企业列表
     * @return \Illuminate\Http\Response
     */
    public function company(Request $request)
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
            //$group_id = 100;
            Log::debug($post);

            //获取分页
            $offset = Help::offset($post['page_size'], $post['page']);
            //查询数据
            $data = Company::orderBy('id', 'DESC');
            //判断是否有部门
            if ($request->has('department_id') && !empty($post['department_id'])) {
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
                    $data->whereIn('department_id', $id);
                } else {
                    $data->where('department_id', $department_id);
                }
            }
            //判断是否有name
            if ($request->has('name') && !empty($post['name'])) {
                $data->where('name', 'LIKE', '%' . $post['name'] . '%');
            }
            $data->select('id', 'name', 'head', 'phone');
            $data->withCount('transportation');
            $data->withCount('dot');
            //查询数据
            try {
                $count = $data->count();
                $res = $data->offset($offset)
                    ->limit($post['page_size'])->get();
            } catch (\Exception $e) {
                Log::error($e);
                return Y::error("查询异常");
            }
            $record = ['data' => $res, 'current_page' => $post['page'],
                'page_size' => $post['page_size'], 'count' => $count];
            Log::info($record);
            return Y::success('查询成功', $record);
        } else {
            return view('admin.manual.index_list');
        }
    }


    /**
     * Display a listing of the resource.
     * 显示人工巡检转运中心列表
     * @return \Illuminate\Http\Response
     */
    public function transportation(Request $request)
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
            $data = Transportation::orderBy('supervision_transportations.id', 'DESC');
            $company = Company::orderBy('id', 'DESC');
            //判断是否有部门
            if ($request->has('department_id') && !empty($post['department_id'])) {
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
                    $data->whereIn('supervision_transportations.department_id', $id);
                    $company->whereIn('department_id', $id);
                } else {
                    $data->where('supervision_transportations.department_id', $department_id);
                    $company->where('department_id', $department_id);
                }
            }
            //判断是否有name
            if ($request->has('name') && !empty($post['name'])) {
                $data->where('supervision_transportations.name', 'LIKE', '%' . $post['name'] . '%');
            }
            // 判断是否有pid
            if ($request->has('pid') && !empty($post['pid'])) {
                $data->where('supervision_transportations.pid', $post['pid']);
            }
            //print_r($data->toSql());
            //exit();
            //查询数据
            try {
                //所属企业
                $com = $company->get();
                //统计总数
                $count = $data->count();
                //左连接查询品牌
                $data->leftJoin('supervision_brands', function ($query) {
                    $query->whereRaw("find_in_set(supervision_brands.id, supervision_transportations.brand_ids)");
                });
                // 左连接所属公司
                $data->leftJoin('supervision_companys', function ($query) {
                    $query->on('supervision_transportations.pid', '=', 'supervision_companys.id');
                });
                //查询字段
                $data->select('supervision_transportations.id', 'supervision_transportations.name',
                    'supervision_transportations.head', 'supervision_transportations.phone', 'supervision_companys.name as company',
                    DB::raw('group_concat(supervision_brands.name) AS bname'),'supervision_transportations.device_count');

                $data->groupBy('supervision_transportations.id', 'supervision_transportations.name',
                    'supervision_transportations.head', 'supervision_transportations.phone','supervision_transportations.device_count', 'company');
                /*print_r($data->toSql());
                exit();*/
                $res = $data->offset($offset)
                    ->limit($post['page_size'])->get();
            } catch (\Exception $e) {
                Log::error($e);
                return Y::error("查询异常");
            }
            $record = ['data' => $res, 'current_page' => $post['page'],
                'page_size' => $post['page_size'], 'count' => $count, 'com' => $com];
            Log::info($record);
            return Y::success('查询成功', $record);
        } else {
            return view('admin.manual.index_list', ["playback_time"=>config('param.manual_playback_time'),
                "time" => config('param.poll_time')]);
        }
    }

    /**
     * Display a listing of the resource.
     * 显示人工巡检网点列表
     * @return \Illuminate\Http\Response
     */
    public function dot(Request $request)
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
            $data = Dot::orderBy('supervision_dots.id', 'DESC');
            $company = Company::orderBy('id', 'DESC');
            //判断是否有部门
            if ($request->has('department_id') && !empty($post['department_id'])) {
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
                    $data->whereIn('supervision_dots.department_id', $id);
                    $company->whereIn('department_id', $id);
                } else {
                    $data->where('supervision_dots.department_id', $department_id);
                    $company->where('department_id', $department_id);
                }
            }
            //判断是否有name
            if ($request->has('name') && !empty($post['name'])) {
                $data->where('supervision_dots.name', 'LIKE', '%' . $post['name'] . '%');
            }
            // 判断是否有pid
            if ($request->has('pid') && !empty($post['pid'])) {
                $data->where('supervision_dots.pid', $post['pid']);
            }
            //print_r($data->toSql());
            //exit();
            //查询数据
            try {
                //所属企业
                $com = $company->get();
                //统计总数
                $count = $data->count();
                //左连接查询品牌
                $data->leftJoin('supervision_brands', function ($query) {
                    $query->whereRaw("find_in_set(supervision_brands.id, supervision_dots.brand_ids)");
                });
                // 左连接所属公司
                $data->leftJoin('supervision_companys', function ($query) {
                    $query->on('supervision_dots.pid', '=', 'supervision_companys.id');
                });
                //查询字段
                $data->select('supervision_dots.id', 'supervision_dots.name',
                    'supervision_dots.head', 'supervision_dots.phone', 'supervision_companys.name as company',
                    DB::raw('group_concat(supervision_brands.name) AS bname'),'supervision_dots.device_count');

                $data->groupBy('supervision_dots.id', 'supervision_dots.name',
                    'supervision_dots.head', 'supervision_dots.phone', 'company','supervision_dots.device_count');
                $res = $data->offset($offset)
                    ->limit($post['page_size'])->get();
            } catch (\Exception $e) {
                Log::error($e);
                return Y::error("查询异常");
            }
            $record = ['data' => $res, 'current_page' => $post['page'],
                'page_size' => $post['page_size'], 'count' => $count, 'com' => $com];
            Log::info($record);
            return Y::success('查询成功', $record);
        } else {
            return view('admin.manual.index_list', ["playback_time"=>config('param.manual_playback_time'),
                "time" => config('param.poll_time')]);
        }
    }

    /**
     * Display a listing of the resource.
     * 添加人工巡检事件
     * @return \Illuminate\Http\Response
     */
    public function add()
    {

    }

    /*
     * @param Request $request
     * 根据类型查询网点，企业，转运中心
     * 人工巡检管理 地图模式
     */
    public function map(Request $request)
    {
        if ($request->isMethod('post')) {
            $post = $request->post();
            Log::debug($post);
            //验证参数是否合法
            $validator = Validator::make($post, [
                'type' => 'required|array',
            ], [], ['type' => '对象类型']);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            #查询当前登录用户所属单位下的网点/转运中心/企业
            $group_id = Auth::guard('admin')->user()->group_id;
            $res = $this->checkDepartment();
            $ids = [];
            if ($res == 1) {
                #可以查看省的所有地级市
                $ids = Department::getIdByPid($group_id);
            } elseif ($res == 2) {
                #可以查看本市
                $ids[] = $group_id;
            }
            $result = [];
            foreach ($post['type'] as $type) {
                #企业
                if ($type == 1) {
                    if (count($ids) == 0) {
                        $list = Company::orderBy('id', 'DESC')->get()->map(function ($value) use ($type) {
                            return ["id" => $value['id'], "name" => $value['name'], "lat" => $value['lat'], "lnt" => $value['lnt'], "position" => $value['position'], "type" => $type];
                        })->toArray();
                    } else {
                        $list = Company::wherein("department_id", $ids)->orderBy('id', 'DESC')->get()
                            ->map(function ($value) use ($type) {
                                return ["id" => $value['id'], "name" => $value['name'], "lat" => $value['lat'], "lnt" => $value['lnt'], "position" => $value['position'], "type" => $type];
                            })->toArray();
                    }
                } #转运中心
                else if ($type == 2) {
                    if (count($ids) == 0) {
                        $list = Transportation::orderBy('id', 'DESC')->get()->map(function ($value) use ($type) {
                            return ["id" => $value['id'], "name" => $value['name'], "lat" => $value['lat'], "lnt" => $value['lnt'], "position" => $value['position'], "type" => $type];
                        })->toArray();
                    } else {
                        $list = Transportation::wherein("department_id", $ids)->orderBy('id', 'DESC')->get()
                            ->map(function ($value) use ($type) {
                                return ["id" => $value['id'], "name" => $value['name'], "lat" => $value['lat'], "lnt" => $value['lnt'], "position" => $value['position'], "type" => $type];
                            })->toArray();
                    }
                } #网点
                else if ($type == 3) {
                    if (count($ids) == 0) {
                        $list = Dot::orderBy('id', 'DESC')->get()->map(function ($value) use ($type) {
                            return ["id" => $value['id'], "name" => $value['name'], "lat" => $value['lat'], "lnt" => $value['lnt'], "position" => $value['position'], "type" => $type];
                        })->toArray();
                    } else {
                        $list = Dot::wherein("department_id", $ids)->get()->map(function ($value) use ($type) {
                            return ["id" => $value['id'], "name" => $value['name'], "lat" => $value['lat'], "lnt" => $value['lnt'], "position" => $value['position'], "type" => $type];
                        })->toArray();
                    }
                } else {
                    return Y::error("对象类型非法");
                }
                $result = array_merge($list, $result);
            }
            return Y::success("查询成功", $result);

        }
        return view('admin.manual.map', ["playback_time"=>config('param.manual_playback_time'),
            "time" => config('param.poll_time')]);
    }

    //查看网点或转运中心下设备列表
    public function device($type, $id)
    {
        //查询巡检模型
        $models = IeventModel::where('id', '!=', 7)->pluck('id')->toarray();
        //查询设备列表
        $devices = Device::where('type', $type)->where('dt_id', $id)
            ->select('id', 'name', 'cameraid')->get()->toArray();
        //查询网点或者转运中心所属机构
        if ($type ==0){
            $department_id = Transportation::where('id', $id)->pluck('department_id')->toarray();
        }else{
            $department_id = Dot::where('id', $id)->pluck('department_id')->toarray();
        }
        $d_id = $department_id[0];
        //组装表名
        $table = 'inspection_events_' . $d_id;
        //查询数据
        foreach ($devices as $k=>$v){
            $count = DB::connection('ievent')->table($table)
                ->where('cameraid', $v['cameraid'])
                ->whereIn('event_type', $models)->count();
            if ($count > 0){
                unset($devices[$k]);
            }
        }
        Log::info($devices);
        return Y::success('查询成功', $devices);
    }
}
