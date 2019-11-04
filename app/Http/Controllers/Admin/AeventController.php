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
use App\Model\Device;
use App\Model\Dot;
use App\Model\Transportation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class AeventController extends Controller
{
    /**
     * Display a listing of the resource.
     * 显示智能分析事件列表
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
                'type' => 'required|array',
            ], [], ['type' => '对象类型']);
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
            //组装表名
            $table = 'analysis_events_' . $group_id;
            //查询数据
            $data = DB::connection('aevent')->table($table);
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
            //判断是否有对象名称
            /*if ($request->has('name') && !empty($post['name'])) {
                //查出所有相关的对象ID
                $trans = Transportation::where('name', 'LIKE', '%' . $post['name'] . '%')->select('id')->get()->toArray();
                $dot = Dot::where('name', 'LIKE', '%' . $post['name'] . '%')->select('id')->get()->toArray();
                // 转运中心
                if ($trans)
                    $data->whereRaw('(`type` = ? and `dt_id` in (?))', [0, array_column($trans, 'id')]);
                // 网点
                if ($dot)
                    $data->orWhereRaw('(`type` = ? and `dt_id` in (?)) ', [1, array_column($dot, 'id')]);
            }*/
            //判断是否有对象
            if ($request->has('id') && !empty($post['id']) && $request->has('objectType')) {
                $data->where('type', $post['objectType']);
                $data->where('dt_id', $post['id']);
            }
            //判断是否有类型
            $data->whereIn('event_type', $post['type']);

            //判断是否有开始时间
            if ($request->has('start_time') && !empty($post['start_time'])) {
                $data->where('created_time', '>=', $post['start_time']);
            }
            //判断是否有结束时间
            if ($request->has('end_time') && !empty($post['end_time'])) {
                $data->where('created_time', '<=', $post['end_time']);
            }
            //判断是否有设备编号
            if ($request->has('cameraid') && !empty($post['cameraid'])) {
                $data->where('cameraid', $post['cameraid']);
            }
            //判断是否有设备名称
            if ($request->has('name') && !empty($post['name'])) {
                $data->where('cameraname', 'like', '%'.$post['cameraname'].'%');
            }
            //排序
            $data->orderBy('id', 'DESC');
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
                    case 0: // 转运中心
                        $object = Transportation::select('name')->find($item->dt_id);
                        if ($object) {
                            $item->object = $object->name;
                        } else {
                            Log::debug('查询ID：' . $item->dt_id . '转运中心名称失败');
                        }
                        if ($department_id == 1) {
                            $item->pic_node_path = config('param.pic_path') . explode(' ', $item->created_time)[0] . '/' . $item->pic_node_path . '/' . $item->event_type . '/C_';
                        } else {
                            $item->pic_node_path = config('param.pic_path') . explode(' ', $item->created_time)[0] . '/' . $item->department_id . '/' . $item->event_type . '/C_';
                        }
                        break;
                    case 1: // 网点
                        $object = Dot::select('name')->find($item->dt_id);
                        if ($object) {
                            $item->object = $object->name;
                        } else {
                            Log::debug('查询ID：' . $item->dt_id . '网点名称失败');
                        }
                        if ($department_id == 1) {
                            $item->pic_node_path = config('param.pic_path') . explode(' ', $item->created_time)[0] . '/' . $item->pic_node_path . '/' . $item->event_type . '/C_';
                        } else {
                            $item->pic_node_path = config('param.pic_path') . explode(' ', $item->created_time)[0] . '/' . $item->department_id . '/' . $item->event_type . '/C_';
                        }
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
            return view('admin.aevent.index_list', ["time" => config('param.playback_time')]);
        }
    }

    //获取类型列表
    public function region()
    {
        //获取当前用户部门id
        $group_id = Auth::guard('admin')->user()->group_id;
        //$group_id = 1;
        if ($group_id < 33) {//1-32为省级及以上
            $data = AnalysisModel::getModels();
        } else {
            $res = AnalysisModelContent::where('department_id', $group_id)->pluck('pid')->toArray();
            //print_r($res);exit();
            $data = AnalysisModel::whereIn('id', $res)->get()->mapWithKeys(function ($item) {
                return [$item['id'] => $item['models']];
            });
        }
        Log::info($data);
        return Y::success('查询成功', $data);
    }

    /**
     * Display the specified resource.
     * 显示智能分析事件信息
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //获取当前用户部门id
        $group_id = Auth::guard('admin')->user()->group_id;
        //$group_id = 271;

        //组装表名
        $table = 'analysis_events_' . $group_id;
        //查询数据
        $data = DB::connection('aevent')->table($table);
        $record = $data->find($id);
        // 监管对象名称
        switch ($record->type) {
            case 0:
                $object = Transportation::select('name')->find($record->dt_id);
                if ($object) {
                    $record->object = $object->name;
                } else {
                    Log::debug('查询ID：' . $record->dt_id . '转运中心名称失败');
                }
                break;
            case 1:
                $object = Dot::select('name')->find($record->dt_id);
                if ($object) {
                    $record->object = $object->name;
                } else {
                    Log::debug('查询ID：' . $record->dt_id . '网点名称失败');
                }
                break;
        }
        return Y::success('查询成功', $record);

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
                'report' => 'required|integer',
                'explain' => 'required|string',
            ], [], ['explain' => '预警说明']);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
        }

        //判断是否提交
        if ($post['report'] == 0) {
            return Y::success('提交成功');
        }
        //获取当前用户部门id
        $group_id = Auth::guard('admin')->user()->group_id;
        //$group_id = 271;

        //组装表名
        $table = 'analysis_events_' . $group_id;
        //获取当前用户id
        $user_id = Auth::guard('admin')->user()->id;
        //$user_id = 1;
        $res['city_bm_id'] = $user_id;
        $res['city_bm_report'] = $post['report'];
        $res['city_bm_explain'] = $post['explain'];
        $res['report_time'] = date('Y-m-d H:i:s', time());
        //修改数据
        if (DB::connection('aevent')->table($table)->where('id', $post['id'])->update($res)) {
            Log::info('上报"' . $post['id'] . '"' . '成功');
            return Y::success('上报成功');
        }
        Log::error('上报"' . $post['id'] . '"' . '失败');
        return Y::error('上报失败');

    }

    public function top(Request $request)
    {
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

        if ($post['type'] == 0){
            $tran = Transportation::find($post['id']);
            $group_id = $tran->department_id;
        }else{
            $dot = Dot::find($post['id']);
            $group_id = $dot->department_id;
        }
        //print_r($group_id);
        //获取当前用户部门id
        //$group_id = Auth::guard('admin')->user()->group_id;
        //$group_id = 1;

        //组装表名
        $table = 'analysis_events_' . $group_id;
        $data = DB::connection('aevent')->table($table);
        $data->where('dt_id', $post['id']);
        $data->where('type', $post['type']);
        $data->orderBy('id', 'DESC');
        $data->take(5);
        //查询数据
        try {
            $record = $data->get();
        }catch (\Exception $e){
            Log::error($e);
            return Y::error("查询异常");
        }
        foreach ($record as $item) {
            $item->pic_path = config('param.pic_path') . explode(' ', $item->created_time)[0]. '/' . $item->department_id . '/' . $item->event_type . '/C_';
        }
        return Y::success("查询成功",$record);
    }

    public function device(Request $request)
    {
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

        if ($post['type'] == 0){
            $tran = Transportation::find($post['id']);
            $group_id = $tran->department_id;
        }else{
            $dot = Dot::find($post['id']);
            $group_id = $dot->department_id;
        }
        $table = 'inspection_events_' . $group_id;
        $data = Device::where('analysis_configs.dt_id', $post['id']);
        $data->where('analysis_configs.type', $post['type']);
        $data->leftJoin('ievent.'.$table, 'ievent.'.$table.'.cameraid',
            '=', 'analysis_configs.cameraid');
        $data->whereRaw('ievent.'.$table.'.cameraid IS NULL');
        $data->select('analysis_configs.*');
        //查询数据
        try {
            $record = $data->get();
        }catch (\Exception $e){
            Log::error($e);
            return Y::error("查询异常");
        }
        return Y::success("查询成功",$record);
    }

}

