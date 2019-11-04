<?php

namespace App\Http\Controllers\Admin;

use App\Library\Help;
use App\Library\Y;
use App\Model\Aevent;
use App\Model\AnalysisModel;
use App\Model\AnalysisModelContent;
use App\Model\Brand;
use App\Model\Company;
use App\Model\Department;
use App\Model\Dot;
use App\Model\Transportation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class AlarmController extends Controller
{
    /**
     * Display a listing of the resource.
     * 显示告警事件列表
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
                'type' => 'required|integer',
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            //获取当前用户部门id
            $group_id = Auth::guard('admin')->user()->group_id;
            //$group_id = 271;
            Log::debug($post);

            //获取分页
            $offset = Help::offset($post['page_size'], $post['page']);
            //判断是否有类型1:视频巡检；0：智能分析
            if ($post['type'] == 1) {
                //组装表名
                $table = 'inspection_events_' . $group_id;
                $prx_table = env('DB_DATABASE_IEVENT') . '.' . $table;
                //查询数据
                $data = DB::connection(env('DB_DATABASE_IEVENT'))->table($prx_table);
            } else {
                //组装表名
                $table = 'analysis_events_' . $group_id;
                $prx_table = env('DB_DATABASE_AEVENT') . '.' . $table;
                //查询数据
                $data = DB::connection(env('DB_DATABASE_AEVENT'))->table($prx_table);
            }
            //联合查询
            $data->leftJoin(env('DB_DATABASE') . '.admins',
                $prx_table . '.city_bm_id',
                '=', env('DB_DATABASE') . '.admins.id');
            //查询已经上报数据
            $data->where($prx_table . '.city_bm_report', 1);
            //查询待审核数据
            $data->where($prx_table . '.is_verify', 0);
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
                    $data->whereIn($prx_table . '.department_id', $id);
                } else {
                    $data->where($prx_table . '.department_id', $department_id);
                }
            }

            //判断是否有类型
            if ($request->has('object_type') && !empty($post['object_type'])) {
                $data->where($prx_table . '.event_type', $post['object_type']);
            }

            $data->select($prx_table . '.*', env('DB_DATABASE') . '.admins.nickname');
            //排序
            $data->orderBy($prx_table . '.id', 'DESC');
            //查询数据
            try {
                $count = $data->count();
                $res = $data->offset($offset)
                    ->limit($post['page_size'])->get();
            } catch (\Exception $e) {
                Log::error($e);
                return Y::error("查询异常");
            }
            foreach ($res as &$item) {
                switch ($item->type) {
                    case 0:
                        $object = Transportation::select('name')->find($item->dt_id);
                        if ($object) {
                            $item->object = $object->name;
                        } else {
                            Log::debug('查询ID：' . $item->dt_id . '转运中心名称失败');
                        }
                        $item->pic_node_path = config('param.pic_path') . explode(' ', $item->created_time)[0] . '/' . $item->department_id . '/' . $item->event_type . '/C_';
                        break;
                    case 1:
                        $object = Dot::select('name')->find($item->dt_id);
                        if ($object) {
                            $item->object = $object->name;
                        } else {
                            Log::debug('查询ID：' . $item->dt_id . '网点名称失败');
                        }
                        $item->pic_node_path = config('param.pic_path') . explode(' ', $item->created_time)[0] . '/' . $item->department_id . '/' . $item->event_type . '/C_';
                        break;
                }
            }
            //组装数据
            $record = ['data' => $res, 'current_page' => $post['page'],
                'page_size' => $post['page_size'], 'count' => $count];
            Log::debug($record);
            //print_r($data->toSql());exit();
            return Y::success('查询成功', $record);
        } else {
            return view('admin.alarm.index_list', ["time" => config('param.playback_time')]);
        }
    }

    //获取类型列表
    public function region(Request $request)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->post();
            //验证参数是否合法
            $validator = Validator::make($post, [
                'type' => 'required|integer',
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            if ($post['type'] == 1) {
                $data = config('custom.ievent');
            } else {
                /*//获取当前用户部门id
                $group_id = Auth::guard('admin')->user()->group_id;
                //$group_id = 1;
                $res = AnalysisModelContent::where('department_id', $group_id)->pluck('pid')->toArray();
                //print_r($res);exit();
                $data = AnalysisModel::whereIn('id', $res)->get()->mapWithKeys(function ($item) {
                    return [$item['id'] => $item['models']];
                });*/
                $data = AnalysisModel::getModels();
            }
            Log::info($data);
            return Y::success('查询成功', $data);
        }
    }

    /**
     * Display the specified resource.
     * 显示告警事件信息
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->post();
            //验证参数是否合法
            $validator = Validator::make($post, [
                'id' => 'required|integer',
                'type' => 'required|integer',
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            //获取当前用户部门id
            $group_id = Auth::guard('admin')->user()->group_id;
            //$group_id = 271;

            //判断是否有类型1:视频巡检；0：智能分析
            if ($post['type'] == 1) {
                //组装表名
                $table = 'inspection_events_' . $group_id;
                $prx_table = env('DB_DATABASE_IEVENT') . '.' . $table;
                //查询数据
                $data = DB::connection(env('DB_DATABASE_IEVENT'))
                    ->table($prx_table);
            } else {
                //组装表名
                $table = 'analysis_events_' . $group_id;
                $prx_table = env('DB_DATABASE_AEVENT') . '.' . $table;
                //查询数据
                $data = DB::connection(env('DB_DATABASE_AEVENT'))
                    ->table($prx_table);
            }
            $data->leftJoin(env('DB_DATABASE') . '.admins',
                $prx_table . '.city_bm_id',
                '=', env('DB_DATABASE') . '.admins.id');
            $data->where($prx_table . '.id', $post['id']);
            $data->select($prx_table . '.*', env('DB_DATABASE') . '.admins.nickname');
            $record = $data->first();
            $record->group_id = $group_id;
            //$record = $data->find($post['id']);
            return Y::success('查询成功', $record);
        }

    }

    /**
     * Display the specified resource.
     * 上报事件
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->post();
            //验证参数是否合法
            $validator = Validator::make($post, [
                'id' => 'required|integer',
                'type' => 'required|integer',
                'report' => 'required|integer',
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            //判断是否上报
            if ($post['report'] == 0) {
                return Y::success('提交成功');
            }

            //获取当前用户部门id
            $group_id = Auth::guard('admin')->user()->group_id;
            //$group_id = 271;

            //获取当前用户id
            $user_id = Auth::guard('admin')->user()->id;
            //$user_id = 3;

            //获取上级部门id
            $department = Department::find($group_id);
            $pid = $department['pid'];

            //判断是否有类型1:视频巡检；0：智能分析
            if ($post['type'] == 1) {
                //组装表名
                $table = 'inspection_events_' . $group_id;
                //查询数据
                $data = DB::connection(env('DB_DATABASE_IEVENT'))->table($table);
                $res = $data->find($post['id']);
                //组装新数组
                $res->city_bm_id = $user_id;
                $res->city_bm_report = $post['report'];
                $res->city_bm_explain = $post['explain'];

                $desc = '';
                if ($post['description']) {
                    $desc = $res->city_bm_desc;
                    $res->city_bm_desc = $post['description'];
                }
                unset($res->id);
                if ($group_id == 1) { //国家管理员不用上报
                    // 是否审核
                    $map = ['is_verify' => 1];
                    $post['description'] ? $map['city_bm_desc'] = $post['description'] : '';
                    if ($post['report'] == 1 && $data->where('id', $post['id'])->update($map)) {
                        Log::info('更新审核"' . $post['id'] . '"' . '成功');
                        return Y::success('提交成功');
                    }
                    // 还原备注
                    $data->where('id', $post['id'])->update(['is_verify' => 0, 'city_bm_desc' => $desc]);
                    Log::error('更新审核"' . $post['id'] . '"' . '失败');
                    return Y::error('提交失败');
                }
                $res->report_time = date('Y-m-d H:i:s', time());
                //更新审核状态
                $map = ['is_verify' => 1];
                $post['description'] ? $map['city_bm_desc'] = $post['description'] : '';
                if (!$data->where('id', $post['id'])->update($map)) {
                    Log::error('上报"' . $post['id'] . '"' . '失败');
                    return Y::error('上报失败');
                }
                // 下级事件ID
                if ($pid == 1) {
                    $res->sid = $group_id . '_' . $post['id'];
                    unset($res->cid);
                    $res->department_id = $group_id;
                } else {
                    $res->cid = $group_id . '_' . $post['id'];
                }

                $res1 = json_decode(json_encode($res), true);
                //组装上级表名
                $p_table = 'inspection_events_' . $pid;
                //数据写入
                $insertGetId = DB::connection(env('DB_DATABASE_IEVENT'))->table($p_table)->insertGetId($res1);
                if ($insertGetId) {
                    $params = [
                        'event_id' => (int)$insertGetId,
                        'event_type' => (int)$res->event_type,
                        'cameraid' => (string)$res->cameraid,
                        'created_time' => (string)$res->created_time,
                        'department_id' => (int)$res->department_id,
                        'pid' => (int)$pid,
                        'object' => (string)$post['object'],
                        'cameraname' => (string)$res->cameraname,
                    ];
                    $result = $pid == 1 ? $this->request('POST', 'gstatistics/updateX', $params) : $this->request('POST', 'sstatistics/updateX', $params);
                    if ($result->ErrCode == 0) {
                        Log::error('上报"' . $post['id'] . '"' . '成功');
                        return Y::error('上报成功');
                    }
                    $data->where('id', $post['id'])->update(['is_verify' => 0, 'city_bm_desc' => $desc]);
                    Log::error('上报"' . $post['id'] . '"' . '失败');
                    return Y::error('上报失败');
                }
                DB::connection(env('DB_DATABASE_IEVENT'))->table($p_table)->delete($insertGetId);
                Log::error('上报"' . $post['id'] . '"' . '失败');
                return Y::error('上报失败');
            } else {
                //组装表名
                $table = 'analysis_events_' . $group_id;
                //查询数据
                $data = DB::connection(env('DB_DATABASE_AEVENT'))->table($table);
                $res = $data->find($post['id']);
                //组装新数组
                $res->city_bm_id = $user_id;
                $res->city_bm_report = $post['report'];
                $res->city_bm_explain = $post['explain'];

                $desc = '';
                if ($post['description']) {
                    $desc = $res->city_bm_desc;
                    $res->city_bm_desc = $post['description'];
                }
                unset($res->id);
                if ($group_id == 1) { //国家管理员不用上报
                    $map = ['is_verify' => 1];
                    $post['description'] ? $map['city_bm_desc'] = $post['description'] : '';
                    if ($post['report'] == 1 && $data->where('id', $post['id'])->update($map)) {
                        Log::info('更新审核"' . $post['id'] . '"' . '成功');
                        return Y::success('提交成功');
                    }
                    Log::error('更新审核"' . $post['id'] . '"' . '失败');
                    return Y::error('提交失败');
                }
                $res->report_time = date('Y-m-d H:i:s', time());
                //更新审核状态
                $map = ['is_verify' => 1];
                $post['description'] ? $map['city_bm_desc'] = $post['description'] : '';
                if (!$data->where('id', $post['id'])->update($map)) {
                    Log::error('上报"' . $post['id'] . '"' . '失败');
                    return Y::error('上报失败');
                }
                // 下级事件ID
                if ($pid == 1) {
                    $res->sid = $group_id . '_' . $post['id'];
                    unset($res->cid);
                    $res->pic_node_path = $res->department_id;
                    $res->department_id = $group_id;
                } else {
                    $res->cid = $group_id . '_' . $post['id'];
                }

                $res1 = json_decode(json_encode($res), true);
                //组装上级表名
                $p_table = 'analysis_events_' . $pid;
                //数据写入
                $insertGetId = DB::connection(env('DB_DATABASE_AEVENT'))->table($p_table)->insertGetId($res1);
                if ($insertGetId) {
                    $params = [
                        'event_id' => (int)$insertGetId,
                        'event_type' => (int)$res->event_type,
                        'cameraid' => (string)$res->cameraid,
                        'created_time' => (string)$res->created_time,
                        'department_id' => (int)$res->department_id,
                        'object' => (string)$post['object'],
                        'cameraname' => (string)$res->cameraname,
                        'pic_name' => (string)$res->pic_name,
                        'pic_node_path' => (string)$res->pic_node_path,
                        'pid' => (int)$pid,
                    ];
                    $result = $pid == 1 ? $this->request('POST', 'gstatistics/updateZ', $params) : $this->request('POST', 'sstatistics/updateZ', $params);
                    if ($result->ErrCode == 0) {
                        Log::error('上报"' . $post['id'] . '"' . '成功');
                        return Y::error('上报成功');
                    }
                    $data->where('id', $post['id'])->update(['is_verify' => 0, 'city_bm_desc' => $desc]);
                    Log::error('上报"' . $post['id'] . '"' . '失败');
                    return Y::error('上报失败');
                }
                $data->where('id', $post['id'])->update(['is_verify' => 0, 'city_bm_desc' => $desc]);
                Log::error('上报"' . $post['id'] . '"' . '失败');
                return Y::error('上报失败');
            }
        }
    }
}
