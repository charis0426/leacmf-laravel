<?php

namespace App\Console\Commands;

use App\Imports\Device_Import_V_1_1;
use App\Model\Company;
use App\Model\Department;
use App\Model\Device;
use App\Model\Dot;
use App\Model\Transportation;
use Illuminate\Console\Command;
use Excel;
use Illuminate\Support\Facades\DB;

class DeviceImportV_1_5 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'device_import_v_1_5 {--path=}';

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

     * @return mixed
     */
    public function handle()
    {
        $dir = $this->option('path');
        if(is_dir($dir)){
            $handle=opendir($dir);
            $darray = array();
            $carray = array();
            $qarray = array();
            $dotarray = array();
            $tranarray = array();
            $devicearray = array();
            while(($file=readdir($handle)) !== false){
                if($file != '.' && $file != '..' ) {
                    $path = $dir . DIRECTORY_SEPARATOR . $file;
                    $collection = Excel::toCollection(new Device_Import_V_1_1(), $path);
                    $array = $collection->toArray();
                    //新增企业数量
                    $j = 0;
                    //新增网点数量
                    $d = 0;
                    //新增转运中心数量
                    $t = 0;
                    //新增点位数量
                    $i = 0;
                    foreach ($array[0] as $k=>$v){
                        if (trim($v[5]) == '监控点') {
                            $govcode = substr(trim($v[1]), 0, 6);
                            $departmemt = Department::whereRaw('FIND_IN_SET(?,govcode)', [$govcode])->get();
                            if ($departmemt->count()) {
                                $d_id = $departmemt[0]->id;
                                $company = Company::where('name', trim($v[2]))->get();
                                if ($company->count()) {
                                    $c_id = $company[0]->id;
                                }else{
                                    $cData = new Company();
                                    $cData->name = trim($v[2]);
                                    $cData->position = '0';
                                    $cData->head = '0';
                                    $cData->phone = '0';
                                    $cData->department_id = $d_id;
                                    $cData->last_time = '0';
                                    $cData->licenses = '0';
                                    $cData->code = '0';
                                    $cData->brand_ids = '0';
                                    $cData->lnt = '0';
                                    $cData->lat = '0';
                                    $cData->save();
                                    $c_id = $cData->id;
                                    $j++;
                                }
                                if (trim($v[3]) != '' && trim($v[4]) == ''){
                                    $dot = Dot::where('name', trim($v[3]))->get();
                                    if ($dot->count()) {
                                        $t_id = $dot[0]->id;
                                    } else {
                                        $DData = new Dot();
                                        $DData->name = trim($v[3]);
                                        $DData->position = '0';
                                        $DData->head = '0';
                                        $DData->phone = '0';
                                        $DData->department_id = $d_id;
                                        $DData->brand_ids = '0';
                                        $DData->pid = $c_id;
                                        $DData->level = '0';
                                        $DData->work_time = '0';
                                        $DData->lnt = '0';
                                        $DData->lat = '0';
                                        $DData->save();
                                        $t_id = $DData->id;
                                        $d++;
                                    }
                                    $type = 1;
                                }elseif (trim($v[3]) == '' && trim($v[4]) != ''){
                                    $tran = Transportation::where('name', trim($v[4]))->get();
                                    if ($tran->count()) {
                                        $t_id = $tran[0]->id;
                                    } else {
                                        $TData = new Transportation();
                                        $TData->name = trim($v[4]);
                                        $TData->position = '0';
                                        $TData->head = '0';
                                        $TData->phone = '0';
                                        $TData->department_id = $d_id;
                                        $TData->last_time = '0';
                                        $TData->licenses = '0';
                                        $TData->pid = $c_id;
                                        $TData->code = '0';
                                        $TData->brand_ids = '0';
                                        $TData->lnt = '0';
                                        $TData->lat = '0';
                                        $TData->save();
                                        $t_id = $TData->id;
                                        $t++;
                                    }
                                    $type = 0;
                                }else{
                                    $qarray[$file][] = $govcode;
                                }
                                $cameraid = trim($v[1]);
                                $device = Device::where('cameraid', $cameraid)->get();
                                //print_r($device);
                                if (!$device->count()) {
                                    $newData['department_id'] = $d_id;
                                    $newData['cameraid'] = $cameraid;
                                    $newData['type'] = $type;
                                    $newData['dt_id'] = $t_id;
                                    $newData['name'] = trim($v[0]);
                                    $newData['nodeid'] = 1;
                                    $newData['models'] = '1';
                                    $newData['frequency'] = 0;
                                    $newData['direction'] = '北';
                                    $newData['url'] = 'rtsp://192.168.1.40/t5.mkv';
                                    $newData['updated_id'] = 0;
                                    $newData['hkserverpara_id'] = 0;
                                    $newData['event_update'] = date('Y-m-d h:i:s', time());
                                    $newData['event_flag'] = 0;
                                    //print_r($newData);
                                    if (Device::create($newData)) {
                                        $i++;
                                    }

                                }
                            }else{
                                $darray[$file][] = $govcode;
                            }
                        }
                    }
                    $carray[$file] = $j;
                    $dotarray[$file] = $d;
                    $tranarray[$file] = $t;
                    $devicearray[$file] = $i;
                }
            }
            print_r('组织机构不存在'.json_encode($darray));
            print_r('---新增企业：' . json_encode($carray));
            print_r('---新增网点：' . json_encode($dotarray));
            print_r('---新增转运中心：' . json_encode($tranarray));
            print_r('---新增点位：' . json_encode($devicearray));
            print_r('---数据错误：' . json_encode($qarray));
        }else{
            print_r($dir.'目录不存在');
        }
    }


}


