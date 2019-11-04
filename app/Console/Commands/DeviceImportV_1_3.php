<?php

namespace App\Console\Commands;

use App\Imports\Device_Import_V_1_1;
use App\Model\Company;
use App\Model\Department;
use App\Model\Device;
use App\Model\Transportation;
use Illuminate\Console\Command;
use Excel;
use Illuminate\Support\Facades\DB;

class DeviceImportV_1_3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'device_import_v_1_3 {--first_path=} {--second_path=} {--type=} {--option=}';

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
     *数据导入按照设备编号取所属机构及所属企业
     *当option=1时：
     *取最后一个“/”后的数据为所属转运中心
     *示例：绿盾北京视频管理平台/北京百世
     * 即"北京百世"为所属转运中心
     *当option=2时：
     *取最后一个“/”后的数据
     *示例：郑州绿盾平台/郑州-韵达转运中心/豫-郑州-韵达-郑州转运中心
     *取最后一个"-"后的数据为转运中心名称
     * 即"郑州转运中心"为所属转运中心
     *当option=3时：
     *取倒数第二和最后一个“/”中间数据
     *示例：郑州绿盾平台/郑州-顺丰转运中心/华中分拨区/顺丰-华中转运中心-邮管局对接/豫-郑州-顺丰-华中转运中心/豫-郑州-顺丰-装卸区
     *取最后一个"-"后的数据为转运中心名称
     * 即"华中转运中心"为所属转运中心
     * @return mixed
     */
    public function handle()
    {
        $ccode['00'] = '邮政行政单位';
        $ccode['01'] = '中国邮政集团';
        $ccode['02'] = '顺丰';
        $ccode['03'] = '园通';
        $ccode['04'] = '中通';
        $ccode['05'] = '申通';
        $ccode['06'] = '韵达';
        $ccode['07'] = '天天';
        $ccode['08'] = '优速';
        $ccode['09'] = '宅急送';
        $ccode['10'] = '速尔';
        $ccode['11'] = '中铁';
        $ccode['12'] = '全峰';
        $ccode['13'] = '远成';
        $ccode['14'] = '苏宁';
        $ccode['15'] = '全一';
        $ccode['16'] = '中外运';
        $i = 0;
        $code = json_decode(file_get_contents(base_path() . DIRECTORY_SEPARATOR . 'code'), true);
        $firstFile = $this->option('first_path');
        $secondFile = $this->option('second_path');
        $type = $this->option('type');
        $option = $this->option('option');
        /*$firstFile = base_path() . DIRECTORY_SEPARATOR . $firstName;
        $secondFile = base_path() . DIRECTORY_SEPARATOR . $secondName;*/
        if (!is_file($firstFile)) {
            print_r($firstFile . '文件不存在');
            return;
        }
        if (!is_file($secondFile)){
            print_r($secondFile.'文件不存在');
            return;
        }
        $firstCollection = Excel::toCollection(new Device_Import_V_1_1(), $firstFile);
        $firstArray = $firstCollection->toArray();
        $secondCollection = Excel::toCollection(new Device_Import_V_1_1(), $secondFile);
        $secondArray = $secondCollection->toArray();
        unset($firstArray[0][0]);
        unset($secondArray[0][0]);
        foreach ($secondArray[0] as $s=>$a){
            $govcode = substr($a[1], 0, 6);
            $departmemt = DB::select('SELECT * FROM `departments` where  FIND_IN_SET(?,govcode)', [$govcode]);
            //print_r($departmemt);
            if (!empty($departmemt)) {
                $d_id = $departmemt[0]->id;
                $codeList[trim($a[0])][0] = $a[1];
                $codeList[trim($a[0])][1] = $d_id;
            }
        }
        //print_r($firstArray);
        foreach ($firstArray[0] as $k=>$v){
            $dName = trim($v[0]);
            if (array_key_exists($dName, $codeList) && $codeList[$dName]) {
                $options = trim($v[1]);
                $cCode = substr($codeList[$dName][0], 6, 2);
                if (array_key_exists($cCode, $ccode) && $ccode[$cCode]) {
                    $cName = $ccode[$cCode];
                    if ($option == 1) {
                        $tName = substr($options, strrpos($options, '/') + 1, strlen($options));
                    }elseif ($option == 2){
                        $new = substr($options, strrpos($options, '/') + 1, strlen($options));
                        $tName = substr($new, strrpos($new, '-') + 1, strlen($new));
                    }else{
                        $new = substr($options, 0, strrpos( $options, '/'));
                        $t = substr($new, strrpos( $new, '/')+1, strlen($new));
                        $tName = substr($t, strrpos($t, '-') + 1, strlen($t));
                    }
                    //print_r($tName.'==');
                    $company = Company::where('name', $cName)->get();
                    if ($company->count()) {
                        $c_id = $company[0]->id;
                    } else {
                        $cData = new Company();
                        $cData->name = $cName;
                        $cData->position = '0';
                        $cData->head = '0';
                        $cData->phone = '0';
                        $cData->department_id = $codeList[$dName][1];
                        $cData->last_time = '0';
                        $cData->licenses = '0';
                        $cData->code = '0';
                        $cData->brand_ids = '0';
                        $cData->lnt = '0';
                        $cData->lat = '0';
                        $cData->save();
                        $c_id = $cData->id;
                    }
                    $tran = Transportation::where('name', $tName)->get();
                    if ($tran->count()) {
                        $t_id = $tran[0]->id;
                    } else {
                        $TData = new Transportation();
                        $TData->name = $tName;
                        $TData->position = '0';
                        $TData->head = '0';
                        $TData->phone = '0';
                        $TData->department_id = $codeList[$dName][1];
                        $TData->last_time = '0';
                        $TData->licenses = '0';
                        $TData->pid = $c_id;
                        $TData->code = '0';
                        $TData->brand_ids = '0';
                        $TData->lnt = '0';
                        $TData->lat = '0';
                        $TData->save();
                        $t_id = $TData->id;
                    }
                    $device = Device::where('cameraid', $codeList[$dName][0])->get();
                    if (!$device->count()) {
                        $newData['department_id'] = $d_id;
                        $newData['cameraid'] = $codeList[$dName][0];
                        $newData['type'] = $type;
                        $newData['dt_id'] = $t_id;
                        $newData['name'] = $dName;
                        $newData['nodeid'] = 1;
                        $newData['models'] = '1';
                        $newData['frequency'] = 0;
                        $newData['direction'] = '北';
                        $newData['url'] = 'rtsp://192.168.1.40/t5.mkv';
                        $newData['updated_id'] = 0;
                        if (Device::create($newData)) {
                            $i++;
                        }
                    }
                }
            }
        }
        print_r('成功导入'.$i.'条数据');
    }


}


