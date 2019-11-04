<?php

namespace App\Console\Commands;

use App\Model\Admin;
use App\Model\AnalysisConfig;
use App\Model\AnalysisModel;
use App\Model\Company;
use App\Model\Department;
use App\Model\Dot;
use App\Model\IeventModel;
use App\Model\Task;
use App\Model\Transportation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class StatisticalTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statistical-task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //查询任务列表
        $task = Task::where('status', 0)->get();
        foreach ($task as $k=>$v){
            //print_r($v);
            //修改任务状态
            $v->status = 1;
            $v->save();
            //获取用户信息
            $user = Admin::find($v['user_id']);
            //获取部门上级id
            $pid = Department::getPid($user->group_id);
            if ($v['type'] == 1) {
                if ($pid == 0 || $pid == 1) {
                    $data = $this->DetailTask($v, $user->group_id, 0);
                } else {
                    $data = $this->DetailTask($v, $user->group_id, 1);
                }
            }else{
                if ($pid == 0 || $pid == 1) {
                    $data = $this->CountTask($v, $user->group_id, 0);
                } else {
                    $data = $this->CountTask($v, $user->group_id, 1);
                }
            }
            //print_r($data);
            $v->status = 2;
            $v->content = json_encode(array_merge($data));
            $v->save();
        }
    }

    //总数统计任务
    private function CountTask($data, $department_id, $type){
        $r['companyIds'] = explode(',', $data['company_ids']);
        $aevent_ids = explode(',', $data['aevents']);
        $ievent_ids = explode(',', $data['ievents']);
        $d = Company::whereIn('id', $r['companyIds']);
        $d->select('name');
        $d->withCount('transportation');
        $d->withCount('dot');
        $res1 = $d->get()->toArray();
        $res2 = array();
        foreach ($res1 as $k=>$v){
            $res2[$v['name']] = $v;
        }
        //print_r($res2);
        $res = array();
        //统计点位数量
        if ($data['devices_count'] == 1) {
            $deviceCount = $this->DeviceCount($r, $data['start_time'], $data['end_time'], $data['type']);
            $i=0;
            foreach ($deviceCount as $k=>$v){
                //print_r($v);
                foreach ($v as $c=>$cv){
                    if ($c != 'time'){
                        $res[$i]['时间'] = $v['time'];
                        $res[$i]['企业名称'] = $c;
                        $res[$i]['转运中心数量'] = $res2[$c]['transportation_count'];
                        $res[$i]['网点数量'] = $res2[$c]['dot_count'];
                        $res[$i]['点位数量'] = $cv;
                    }
                    $i++;
                }
            }
        }

        if ($aevent_ids[0] != '') {
            $aeventCount = $this->AeventCount($department_id, $aevent_ids, $r, $data['start_time'], $data['end_time'], $type, $data['type']);
            if (!empty($res)){
                foreach ($aeventCount as $k=>$v){
                    $i=0;
                    foreach ($v as $c=>$cv){
                        foreach ($cv as $t=>$d){
                            if ($t != 'time'){
                                $res[$i][$k] = $d;
                                //print_r($i);
                            }
                            $i++;
                        }
                    }
                }
            }else{
                foreach ($aeventCount as $k=>$v){
                    $i=0;
                    foreach ($v as $c=>$cv){
                        foreach ($cv as $t=>$d){
                            if ($t != 'time'){
                                $res[$i]['时间'] = $cv->time;
                                $res[$i]['企业名称'] = $t;
                                $res[$i]['转运中心数量'] = $res2[$t]['transportation_count'];
                                $res[$i]['网点数量'] = $res2[$t]['dot_count'];
                                $res[$i][$k] = $d;
                                //print_r($i);
                            }
                            $i++;
                        }
                    }
                }
            }
        }
        //统计巡检事件
        if ($ievent_ids[0] != '') {
            $ieventCount = $this->IeventCount($department_id, $ievent_ids, $r, $data['start_time'], $data['end_time'], $type, $data['type']);
            if (!empty($res)){
                foreach ($ieventCount as $k=>$v){
                    $i=0;
                    foreach ($v as $c=>$cv){
                        foreach ($cv as $t=>$d){
                            if ($t != 'time'){
                                $res[$i][$k] = $d;
                                //print_r($i);
                            }
                            $i++;
                        }
                    }
                }
            }else{
                foreach ($ieventCount as $k=>$v){
                    $i=0;
                    foreach ($v as $c=>$cv){
                        foreach ($cv as $t=>$d){
                            if ($t != 'time'){
                                $res[$i]['时间'] = $cv->time;
                                $res[$i]['企业名称'] = $t;
                                $res[$i]['转运中心数量'] = $res2[$t]['transportation_count'];
                                $res[$i]['网点数量'] = $res2[$t]['dot_count'];
                                $res[$i][$k] = $d;
                                //print_r($i);
                            }
                            $i++;
                        }
                    }
                }
            }
        }
        return $res;
    }

    //详细统计任务
    private function DetailTask($data, $department_id, $type)
    {
        $r['companyIds'] = explode(',', $data['company_ids']);
        $r['transportationIds'] = explode(',', $data['transportation_ids']);
        $r['dotIds'] = explode(',', $data['dot_ids']);
        $aevent_ids = explode(',', $data['aevents']);
        $ievent_ids = explode(',', $data['ievents']);
        //查询对象公司名
        $t = Transportation::whereIn('supervision_transportations.id', $r['transportationIds']);
        $t->leftJoin('supervision_companys', 'supervision_companys.id', '=', 'supervision_transportations.pid');
        $t->select('supervision_companys.name AS cname', 'supervision_transportations.name AS name');
        $tdata = $t->get()->mapWithKeys(function ($item) {
            return [$item['name'] => $item['cname']];
        });
        //查询对象公司名
        $d = Dot::whereIn('supervision_dots.id', $r['dotIds']);
        $d->leftJoin('supervision_companys', 'supervision_companys.id', '=', 'supervision_dots.pid');
        $d->select('supervision_companys.name AS cname', 'supervision_dots.name AS name');
        $ddata = $d->get()->mapWithKeys(function ($item) {
            return [$item['name'] => $item['cname']];
        });
        //print_r($tdata->toarray());
        $res = array();
        //统计点位数量
        if ($data['devices_count'] == 1) {
            $deviceCount = $this->DeviceCount($r, $data['start_time'], $data['end_time'], $data['type']);
            $i=0;
            foreach ($deviceCount as $k=>$v){
                //print_r($v);
                foreach ($v as $c=>$cv){
                    if ($c != 'time'){
                        $res[$i]['时间'] = $v['time'];
                        if(isset($tdata[$c])){
                            $res[$i]['企业名称'] = $tdata[$c];
                            $res[$i]['类型'] = '转运中心';
                            $res[$i]['名称'] = $c;
                            $res[$i]['点位数量'] = $cv;
                        }
                        if(isset($ddata[$c])){
                            $res[$i]['企业名称'] = $ddata[$c];
                            $res[$i]['类型'] = '网点';
                            $res[$i]['名称'] = $c;
                            $res[$i]['点位数量'] = $cv;
                        }
                    }
                    $i++;
                }
            }
        }
        //print_r($deviceCount);

        //print_r($res);
        //
        //统计智能个分析事件

        if ($aevent_ids[0] != '') {
            $aeventCount = $this->AeventCount($department_id, $aevent_ids, $r, $data['start_time'], $data['end_time'], $type, $data['type']);
            if (!empty($res)) {
                foreach ($aeventCount as $k => $v) {
                    $i = 0;
                    foreach ($v as $c => $cv) {
                        foreach ($cv as $t => $d) {
                            if ($t != 'time') {
                                $res[$i][$k] = $d;
                            }
                            $i++;
                        }
                    }
                }
            }else{
                foreach ($aeventCount as $k=>$v){
                    $i=0;
                    foreach ($v as $c=>$cv){
                        //print_r($v);
                        foreach ($cv as $t=>$d){
                            //print_r($t);
                            if ($t != 'time') {
                                $res[$i]['时间'] = $cv->time;
                                if (isset($tdata[$t])) {
                                    $res[$i]['企业名称'] = $tdata[$t];
                                    $res[$i]['类型'] = '转运中心';
                                    $res[$i]['名称'] = $t;
                                }
                                if (isset($ddata[$t])) {
                                    $res[$i]['企业名称'] = $ddata[$t];
                                    $res[$i]['类型'] = '网点';
                                    $res[$i]['名称'] = $t;
                                }
                                $res[$i][$k] = $d;
                            }
                            $i++;
                        }
                    }
                }
            }

        }
        //print_r($res);
        //统计巡检事件
        if ($ievent_ids[0] != '') {
            $ieventCount = $this->IeventCount($department_id, $ievent_ids, $r, $data['start_time'], $data['end_time'], $type, $data['type']);
            if (!empty($res)) {
                foreach ($ieventCount as $k => $v) {
                    $i = 0;
                    foreach ($v as $c => $cv) {
                        foreach ($cv as $t => $d) {
                            if ($t != 'time') {
                                $res[$i][$k] = $d;
                                //print_r($i);
                            }
                            $i++;
                        }
                    }
                }
            }else{
                foreach ($ieventCount as $k=>$v){
                    $i=0;
                    foreach ($v as $c=>$cv){
                        foreach ($cv as $t=>$d){
                            if ($t != 'time') {
                                $res[$i]['时间'] = $cv->time;
                                if (isset($tdata[$t])) {
                                    $res[$i]['企业名称'] = $tdata[$t];
                                    $res[$i]['类型'] = '转运中心';
                                    $res[$i]['名称'] = $t;
                                }
                                if (isset($ddata[$t])) {
                                    $res[$i]['企业名称'] = $ddata[$t];
                                    $res[$i]['类型'] = '网点';
                                    $res[$i]['名称'] = $t;
                                }
                                $res[$i][$k] = $d;
                            }
                            $i++;
                        }
                    }
                }
            }
        }
        //print_r($res);
        /*$recrod['deviceCount'] = $deviceCount;
        $recrod['aeventCount'] = $aeventCount;
        $recrod['ieventCount'] = $ieventCount;*/
        //return $recrod;
        return $res;
    }

    //统计点位数量
    private function DeviceCount($r, $s_time, $e_time, $type)
    {

        $data = AnalysisConfig::where('created_at', '>=', $s_time);
        $data->where('created_at', '<=', $e_time);
        //$data->select(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d') AS time"));
        $select = "DATE_FORMAT(created_at,'%Y-%m-%d') AS time,";
        //判断统计类型
        if ($type == 0) {
            //判断数据是否存在
            if ($r['companyIds'][0] != '') {
                foreach ($r['companyIds'] as $c => $cv) {
                    $name = Company::find($cv);
                    $select .= " COUNT(CASE WHEN (type=0 AND dt_id IN (
                    SELECT id FROM supervision_transportations WHERE pid=" . $cv . ")) OR 
                    (type=1 AND dt_id IN (SELECT id FROM supervision_dots WHERE pid=" . $cv . ")) 
                    THEN 1 END) AS '" . $name['name'] . "',";
                    $data->select(DB::raw(" COUNT(CASE WHEN (type=0 AND dt_id IN (SELECT id FROM supervision_transportations WHERE pid=1)) OR (type=1 AND dt_id IN (SELECT id FROM supervision_dots WHERE pid=1)) THEN 1 END) AS 'c_1',"));
                }
            }
        }else {
            if ($r['transportationIds'][0] != '') {
                foreach ($r['transportationIds'] as $t => $tv) {
                    $name = Transportation::find($tv);
                    $select .= " COUNT(CASE WHEN type=0 AND dt_id=" . $tv . " THEN 1 END) AS '" . $name['name'] . "',";
                }
            }
            if ($r['dotIds'][0] != '') {
                foreach ($r['dotIds'] as $d => $dv) {
                    $name = Dot::find($dv);
                    $select .= " COUNT(CASE WHEN type=1 AND dt_id=" . $dv . " THEN 1 END) AS '" . $name['name'] . "',";
                }
            }
        }
        $select = rtrim($select, ',');
        $data->select(DB::raw($select));
        $data->groupBy(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"));
        //print_r($data->toSql());
        $res = $data->get()->toArray();
        return $res;
    }

    //统计智能分析事件
    private function AeventCount($department_id, $aevents, $r, $s_time, $e_time, $type, $c_type)
    {
        //组装表名
        $table = 'analysis_events_' . $department_id;
        foreach ($aevents as $k=>$v) {
            //查询数据
            $data = DB::connection('aevent')->table($table);
            $data->where('report_time', '>=', $s_time);
            $data->where('report_time', '<=', $e_time);
            $select = "DATE_FORMAT(report_time,'%Y-%m-%d') AS time,";
            //判断统计类型
            if ($c_type == 0) {
                //判断数据是否存在
                if ($r['companyIds'][0] != '') {
                    foreach ($r['companyIds'] as $c => $cv) {
                        $name = Company::find($cv);
                        $select .= " COUNT(CASE WHEN company_id=" . $cv . " THEN 1 END) AS '" . $name['name'] . "',";
                    }
                }
            }else {
                if ($r['transportationIds'][0] != '') {
                    foreach ($r['transportationIds'] as $t => $tv) {
                        $name = Transportation::find($tv);
                        $select .= " COUNT(CASE WHEN type=0 AND dt_id=" . $tv . " THEN 1 END) AS '" . $name['name'] . "',";
                    }
                }
                if ($r['dotIds'][0] != '') {
                    foreach ($r['dotIds'] as $d => $dv) {
                        $name = Dot::find($dv);
                        $select .= " COUNT(CASE WHEN type=1 AND dt_id=" . $dv . " THEN 1 END) AS '" . $name['name'] . "',";
                    }
                }
            }
            $select = rtrim($select, ',');
            $data->select(DB::raw($select));
            $data->groupBy(DB::raw("DATE_FORMAT(report_time,'%Y-%m-%d')"));
            if ($type ==1){
                $data->where('city_bm_report', 1);
            }
            //print_r($data->toSql());exit();
            $data->where('event_type', $v);
            $res = $data->get()->toArray();
            $aev = AnalysisModel::find($v);
            $record[$aev['models']] = $res;
            //print_r($record);
            //$data = '';
        }
        return $record;
    }

    //统计智能分析事件
    private function IeventCount($department_id, $ievents, $r, $s_time, $e_time, $type, $c_type)
    {
        //组装表名
        $table = 'inspection_events_' . $department_id;
        foreach ($ievents as $k=>$v) {
            //查询数据
            $data = DB::connection('ievent')->table($table);
            $data->where('report_time', '>=', $s_time);
            $data->where('report_time', '<=', $e_time);
            $select = "DATE_FORMAT(report_time,'%Y-%m-%d') AS time,";
            //判断统计类型
            if ($c_type == 0) {
                //判断数据是否存在
                if ($r['companyIds'][0] != '') {
                    foreach ($r['companyIds'] as $c => $cv) {
                        $name = Company::find($cv);
                        $select .= " COUNT(CASE WHEN company_id=" . $cv . " THEN 1 END) AS '" . $name['name'] . "',";
                        //$data->select(DB::raw(" COUNT(CASE WHEN (type=0 AND dt_id IN (SELECT id FROM supervision_transportations WHERE pid=1)) OR (type=1 AND dt_id IN (SELECT id FROM supervision_dots WHERE pid=1)) THEN 1 END) AS 'c_1',"));
                    }
                }
            }else {
                if ($r['transportationIds'][0] != '') {
                    foreach ($r['transportationIds'] as $t => $tv) {
                        $name = Transportation::find($tv);
                        $select .= " COUNT(CASE WHEN type=0 AND dt_id=" . $tv . " THEN 1 END) AS '" . $name['name'] . "',";
                    }
                }
                if ($r['dotIds'][0] != '') {
                    foreach ($r['dotIds'] as $d => $dv) {
                        $name = Dot::find($dv);
                        $select .= " COUNT(CASE WHEN type=1 AND dt_id=" . $dv . " THEN 1 END) AS '" . $name['name'] . "',";
                    }
                }
            }
            $select = rtrim($select, ',');
            $data->select(DB::raw($select));
            $data->groupBy(DB::raw("DATE_FORMAT(report_time,'%Y-%m-%d')"));

            if ($type ==1){
                $data->where('city_bm_report', 1);
            }
            //print_r($data->toSql());
            $data->where('event_type', $v);
            $res = $data->get()->toArray();
            $iev = IeventModel::find($v);
            $record[$iev['name']] = $res;
            //print_r($res);
            //$data = '';
        }
        return $record;
    }


    private function execlData($data){
        print_r($data);
    }
}


