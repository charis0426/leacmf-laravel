<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ReportExport;
use App\Exports\StatisticalExport;
use App\Library\Help;
use App\Library\Y;
use App\Model\AnalysisModel;
use App\Model\Company;
use App\Model\Department;
use App\Model\Dot;
use App\Model\IeventModel;
use App\Model\Task;
use App\Model\Transportation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Excel;

class TasksController extends Controller
{
    /**
     * 定制分析任务列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        if($request->isMethod('post')) {
            #验证数据合法性
            $post = $request->post();
            $validator = Validator::make($post, [
                'start_time' => 'string',
                'end_time'   => 'string',
                'name'       => 'string',
                'page'       => 'required|int',
                'page_size'  => 'required|int'
            ], [], [
                'start_time' => '开始时间',
                'end_time'   => '结束时间',
                'name'       => '报告名称',
                'page'       => '页码',
                'page_size'  => '分页显示数量'
            ]);
            if ($validator->fails()) {
                return Y::error($validator->errors());
            }
            //获取当前用户部门id
            $user_id = Auth::guard('admin')->user()->id;
            $data = Task::orderBy('id', 'DESC');
            $data = $data->where('user_id', $user_id);
            #判断时间区间选择
            if(isset($post['start_time']) && $post['start_time']!=""){
                $data = $data->where('start_time','>=',$post['start_time']);
            }
            if(isset($post['end_time']) && $post['end_time']!=""){
                $data = $data->where('end_time','<=',$post['end_time']);
            }
            if(isset($post['name']) && $post['name'] != ""){
                $data = $data->where('name','like','%'.$post['name'].'%');
            }
            try {
                $count = $data->count();
                $res = $data->offset(($post['page'] - 1) * $post['page_size'])
                    ->limit($post['page_size'])->get();
            }catch (\Exception $e){
                Log::error($e);
                return Y::error("查询异常");
            }
            $result=['data'=>$res,'current_page'=>$post['page'],
                'page_size'=>$post['page_size'],'total'=>$count];
            return Y::success("成功",$result);
        }
        #判断当前用户所属结构
        $p_id = $this->checkDepartment();
        $group_id = Auth::guard('admin')->user()->group_id;
        #返回任务列表首页模版
        return view('admin.task.index_list',['p_id'=>$p_id,'g_id'=>$group_id]);
    }

    /**
     * 统计分析任务列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function report(Request $request){
        if($request->isMethod('post')) {
            //获取当前用户部门id
            $group_id = Auth::guard('admin')->user()->group_id;
            //$group_id = 1;
            #验证数据合法性
            $post = $request->post();
            $validator = Validator::make($post, [
                'start_time' => 'string',
                'end_time'   => 'string',
                'name'       => 'string',
                'page'       => 'required|int',
                'page_size'  => 'required|int'
            ], [], [
                'start_time' => '开始时间',
                'end_time'   => '结束时间',
                'name'       => '报告名称',
                'page'       => '页码',
                'page_size'  => '分页显示数量'
            ]);
            if ($validator->fails()) {
                return Y::error($validator->errors());
            }
            //获取分页
            $offset = Help::offset($post['page_size'], $post['page']);
            //组装表名
            $table = 'statistics_report_' . $group_id;
            //查询数据
            $data = DB::connection('report')->table($table);
            #判断时间区间选择
            if(isset($post['start_time']) && $post['start_time']!=""){
                $data = $data->where('stop_time','>=',$post['start_time']);
            }
            if(isset($post['end_time']) && $post['end_time']!=""){
                $data = $data->where('stop_time','<=',$post['end_time']);
            }
            if(isset($post['name']) && $post['name'] != ""){
                $data = $data->where('report_name','like','%'.$post['name'].'%');
            }
            $data->select('id', 'report_name', 'stop_time');
            try {
                $count = $data->count();
                $res = $data->offset($offset)
                    ->limit($post['page_size'])->get();
            }catch (\Exception $e){
                Log::error($e);
                return Y::error("查询异常");
            }
            $result=['data'=>$res,'current_page'=>$post['page'],
                'page_size'=>$post['page_size'],'total'=>$count];
            return Y::success("成功",$result);
        }
        #返回任务列表首页模版
        return view('admin.task.report_list');
    }

    /**
     * Display the specified resource.
     * 显示统计分析任务信息
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //获取当前用户部门id
        $group_id = Auth::guard('admin')->user()->group_id;
        //$group_id = 1;

        //组装表名
        $table = 'statistics_report_' . $group_id;
        //查询数据
        $data = DB::connection('report')->table($table);
        $record = $data->find($id);
        return Y::success('查询成功', $record);

    }

    /**
     * 导出任务报告
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reportExport($id){
        //获取当前用户部门id
        $group_id = Auth::guard('admin')->user()->group_id;
        //$group_id = 1;

        //组装表名
        $table = 'statistics_report_' . $group_id;
        //查询数据
        $data = DB::connection('report')->table($table);
        $record = $data->find($id);
        $res = $this->handleData($record);
        $widths = ['A' => 30, 'B' => 30];
        $arr = ['A1:B1', 'A4:B4', 'A7:B7', 'A10:B10', 'A18:B18'];
        //print_r($res);
        return Excel::download(new ReportExport($res, $arr, $widths), $record->report_name . '.xlsx');
    }

    private function handleData($record)
    {
        $i = 0;
        $res[0][0] = '监管对象';
        $res[1][0] = '减少/新增';
        $res[1][1] = '数量';
        if ($record->supervisor <0){
            $res[2][0] = '减少';
        }else{
            $res[2][0] = '新增';
        }
        $res[2][1] = $record->supervisor;
        $res[3][0] = '点位数量';
        $res[4][0] = '减少/新增';
        $res[4][1] = '数量';
        if ($record->number_of_dots <0){
            $res[5][0] = '减少';
        }else{
            $res[5][0] = '新增';
        }
        $res[5][1] = $record->number_of_dots;
        $res[6][0] = '重点对象';
        $res[7][0] = '减少/新增';
        $res[7][1] = '数量';
        if ($record->key_objects <0){
            $res[8][0] = '减少';
        }else{
            $res[8][0] = '新增';
        }
        $res[8][1] = $record->key_objects;
        $res[9][0] = '视频巡检';
        $res[10][0] = '事件类型';
        $res[10][1] = '事件数量';
        $res[11][0] = '断网';
        $res[11][1] = $record->broken_network;
        $res[12][0] = '无信号';
        $res[12][1] = $record->no_signal;
        $res[13][0] = '黑屏';
        $res[13][1] = $record->blackscreen;
        $res[14][0] = '花屏';
        $res[14][1] = $record->blurred_screen;
        $res[15][0] = '遮挡';
        $res[15][1] = $record->shelter_from;
        $res[16][0] = '冻结';
        $res[16][1] = $record->frozen;
        $res[17][0] = '智能分析';
        $res[18][0] = '事件类型';
        $res[18][1] = '事件数量';
        $res[19][0] = '暴力分拣';
        $res[19][1] = $record->violent_sorting;
        $res[20][0] = '安检机未运行';
        $res[20][1] = $record->sec_not_run;
        $res[21][0] = '安检人员不在岗';
        $res[21][1] = $record->not_on_duty;
        $res[22][0] = '传送带跨越';
        $res[22][1] = $record->belt_crossing;
        $res[23][0] = '火灾';
        $res[23][1] = $record->fire;
        $res[24][0] = '爆仓';
        $res[24][1] = $record->burst_warehouse;
        $res[25][0] = '网点是否营业';
        $res[25][1] = $record->outlet_open;
        $res[26][0] = '疑似件';
        $res[26][1] = $record->suspected_package;
        return $res;
    }


    /**
     * 任务详情
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id){
        try{
            $res = Tasks::where('id',$id)->first();
        }catch (\Exception $e){
            Log::error($e);
            return Y::page("查询异常，请稍后重试");
        }
        if($res){
            return view('',['detail'=>$res]);
        }
        return Y::page("查询失败，请稍后重试");
    }


    /**
     * 导出任务报告
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function export($id){
        $data = Task::find($id);
        $content = json_decode($data['content'], true);
        if ($data['type'] == 1) {
            if ($data['transportation_ids'] != null){
                $t_ids = explode(',', $data['transportation_ids']);
                $t_c = count($t_ids);
            }else{
                $t_c = 0;
            }
            if ($data['dot_ids'] != null) {
                $d_ids = explode(',', $data['dot_ids']);
                $d_c = count($d_ids);
            }else{
                $d_c = 0;
            }
            $t_count = $t_c + $d_c;
            $widths = ['A' => 12, 'B' => 30, 'C' => 12, 'D' => 35];
        }else{
            $t_count = count(explode(',', $data['company_ids']));
            $widths = ['A' => 12, 'B' => 30, 'C' => 12, 'D' => 10];
        }
        $dates = $this->getDateFromRange($data['start_time'], $data['end_time']);
        $d_count = count($dates);
        $arr = [];
        for ($i=0 ;$i<$d_count-1; $i++){
            $start = $i*$t_count+2;
            $end = ($i+1)*$t_count+1;
            $arr[] = 'A'.$start.':A'.$end;
        }

        //print_r($content);exit();
        //print_r(['A2:A6', 'A7:A11', 'A12:A16']);
        return Excel::download(new StatisticalExport($content, $arr, $widths), $data['name'] . '.xlsx');
    }

    /**
     * 获取指定日期段内每一天的日期
     * @param  Date  $startdate 开始日期
     * @param  Date  $enddate   结束日期
     * @return Array
     */
    private function getDateFromRange($startdate, $enddate){

        $stimestamp = strtotime($startdate);
        $etimestamp = strtotime($enddate);

        // 计算日期段内有多少天
        $days = ($etimestamp-$stimestamp)/86400+1;

        // 保存每天日期
        $date = array();

        for($i=0; $i<$days; $i++){
            $date[] = date('Y-m-d', $stimestamp+(86400*$i));
        }

        return $date;
    }

    /**
     * Show the form for creating a new resource.
     * 获取部门列表
     * @return \Illuminate\Http\Response
     */
    public function department(Request $request)
    {
        if($request->isMethod('post')) {
            $post = $request->post();
            //获取当前用户部门id
            $group_id = Auth::guard('admin')->user()->group_id;
            //$group_id = 271;

            Log::debug($post);
            //验证参数是否合法
            $validator = Validator::make($post, [
                'type' => 'required|between:0,2',
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            if (Department::getPid($group_id) == 0) {
                if ($post['type'] == 1) {
                    $res = Department::where('pid', 1)->get()->map(function ($item) {
                        return ["value"=>$item['id'],'name' => $item['name']];
                    })->toArray ();
                } elseif ($post['type'] == 2) {
                    $res = Department::whereNotIn('pid', [0, 1])->get()->map(function ($item) {
                        return ["value"=>$item['id'],'name' => $item['name']];
                    })->toArray ();
                } else {
                    $res = array();
                }
            }else{
                $pid = Department::getPid($group_id);
                if ($pid == 1){
                    $res = Department::where('pid', $group_id)->get()->map(function ($item) {
                        return ["value"=>$item['id'],'name' => $item['name']];
                    })->toArray ();
                }else{
                    $res = Department::where('id', $group_id)->get()->map(function ($item) {
                        return ["value"=>$item['id'],'name' => $item['name']];
                    })->toArray ();
                }
            }

            return Y::success('查询成功', $res);
        }
    }

    /**
     * Show the form for creating a new resource.
     * 获取企业转运中心网点列表
     * @return \Illuminate\Http\Response
     */
    public function object(Request $request)
    {
        if($request->isMethod('post')) {
            $post = $request->post();

            Log::debug($post);
            //验证参数是否合法
            $validator = Validator::make($post, [
                'department_ids' => 'required|array',
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }

            //$d_ids = explode(',', $post['department_ids']);
            //print_r($d_ids);
            //判断是否是国家级
            if ($post['department_ids'][0] == 1){
                $department_ids = Department::whereNotIn('pid', [0,1])->pluck('id')->toarray();
                //print_r($department_ids);
            }else{
                $departments = Department::whereIn('pid', $post['department_ids'])->pluck('id')->toarray();
                $department_ids = array_merge($departments, $post['department_ids']);
            }
            $company = Company::whereIn('department_id', $department_ids)
                ->select('id', 'name')->get()->map(function ($item) {
                    return ["value"=>$item['id'],'name' => $item['name']];
                })->toArray ();
            /*$transportation = Transportation::whereIn('department_id', $department_ids)
                ->select('id', 'name')->get()->map(function ($item) {
                    return ["value"=>$item['id'],'name' => $item['name']];
                })->toArray ();
            $dot = Dot::whereIn('department_id', $department_ids)
                ->select('id', 'name')->get()->map(function ($item) {
                    return ["value"=>$item['id'],'name' => $item['name']];
                })->toArray ();
            $record['company'] = $company;
            $record['transportation'] = $transportation;
            $record['dot'] = $dot;*/

            return Y::success('查询成功', $company);

        }
    }


    /**
     * Show the form for creating a new resource.
     * 添加统计分析任务
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        if($request->isMethod('post')) {
            $post = $request->all();
            Log::debug($post);
            //验证参数是否合法
            $validator = Validator::make($post, [
                'name' => 'required|max:64',
                'start_time' => 'required|string',
                'end_time' => 'required|string',
                'department_ids' => 'required|string',
                'company_ids' => 'required|string',
                'object_ids' => 'required|string',
                'type' => 'required|between:0,1',
            ],[],
                [
                    'name'=>'任务名称',
                    'start_time' => '开始时间',
                    'end_time' => '结束时间',
                    'department_ids' => '部门',
                    'company_ids' => '企业',
                    'object_ids' => '对象数据',
                    'type' => '输出类型',
                ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            $object_ids = explode(',', $post['object_ids']);
            $company_ids = explode(',', $post['company_ids']);
            if(in_array(0, $object_ids)){
                $transportation = Transportation::whereIn('pid', $company_ids)->pluck('id')->toArray();
                $post['transportation_ids'] = implode(',', $transportation);
            }
            if(in_array(1, $object_ids)){
                $dot = Dot::whereIn('pid', $company_ids)->pluck('id')->toArray();
                $post['dot_ids'] = implode(',', $dot);
            }
            //print_r($post);
            $post['user_id'] = Auth::guard('admin')->user()->id;
            //$post['user_id'] = 1;
            //数据写入
            $data = Task::where('type', $post['type']);
            $data->where('department_ids', $post['department_ids']);
            $data->where('user_id', $post['user_id']);
            $data->where('start_time', $post['start_time']);
            $data->where('end_time', $post['end_time']);
            if (array_key_exists('transportation_ids', $post)){
                $data->where('transportation_ids', $post['transportation_ids']);
            }else {
                $data->where('transportation_ids', '');
            }
            if (array_key_exists('dot_ids', $post)){
                $data->where('dot_ids', $post['dot_ids']);
            }else {
                $data->where('dot_ids', '');
            }
            $data->where('ievents', $post['ievents']);
            $data->where('aevents', $post['aevents']);
            if (array_key_exists('devices_count', $post)){
                $data->where('devices_count', $post['devices_count']);
            }else {
                $data->where('devices_count', 0);
            }
            $res = $data->get();
            if ($res->count()){
                return Y::error('此定制报告已存在');
            }
            try {
                Task::create($post);
            } catch (\Exception $e) {
                Log::error($e);
                return Y::error('添加失败');
            }
            Log::info('添加任务"'. $post['name'] .'"' . '成功');
            return Y::success('添加成功');

        }else{
            $record['ievent'] = IeventModel::getModels();
            $record['aevent'] = AnalysisModel::getModels();
            //print_r($record);
            #返回任务列表首页模版
            return view('admin.task.add', [
                'data'     => $record,
            ]);
        }
    }




}
