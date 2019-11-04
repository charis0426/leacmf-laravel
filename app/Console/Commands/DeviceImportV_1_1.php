<?php

namespace App\Console\Commands;

use App\Imports\Device_Import_V_1_1;
use App\Model\Company;
use App\Model\Department;
use App\Model\Device;
use App\Model\Transportation;
use Illuminate\Console\Command;
use Excel;

class DeviceImportV_1_1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'device_import_v_1_1 {--first_path=} {--second_path=} {--type=}';

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
        $firstFile = $this->option('first_path');
        $secondFile = $this->option('second_path');
        $type = $this->option('type');
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
        unset($secondArray[0][0]);
        foreach ($secondArray[0] as $s => $a){
            $codeList[trim($a[0])] = trim($a[1]);
        }
        unset($firstArray[0][0]);
        foreach ($firstArray[0] as $k=> $v){
            $dName = trim($v[0]);
            $option = trim($v[1]);
            $new = substr($option, 0, strrpos( $option, '/'));
            $t = substr($new, strrpos( $new, '/')+1, strlen($new));
            $optionArray = explode('-', $t);
            //print_r($optionArray);
            $cName = trim($optionArray[2]);
            $tName = trim($optionArray[3]);
            $departmemt = Department::where('name', 'like', trim($optionArray[1].'%'))->get();
            if ($departmemt->count()) {
                $d_id = $departmemt[0]->id;
                $company = Company::where('name', $cName)->get();
                if ($company->count()) {
                    $c_id = $company[0]->id;
                } else {
                    $cData = new Company();
                    $cData->name = $cName;
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
                }
                $tran = Transportation::where('name', $tName)->get();
                if ($tran->count()){
                    $t_id = $tran[0]->id;
                }else{
                    $TData = new Transportation();
                    $TData->name = $tName;
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
                }
                if ($codeList[$dName]) {
                    $device = Device::where('cameraid', $codeList[$dName])->get();
                    if (!$device->count()) {
                        $newData['department_id'] = $d_id;
                        $newData['cameraid'] = $codeList[$dName];
                        $newData['type'] = $type;
                        $newData['dt_id'] = $t_id;
                        $newData['name'] = $dName;
                        $newData['nodeid'] = 1;
                        $newData['models'] = '1';
                        $newData['frequency'] = 0;
                        $newData['direction'] = '北';
                        $newData['url'] = 'rtsp://192.168.1.40/t5.mkv';
                        $newData['updated_id'] = 0;
                        Device::create($newData);
                    }
                }

            }
        }
    }


}


