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

class DeviceImportV_1_4 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'device_import_v_1_4 {--path=} {--type=}';

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
        $type = $this->option('type');
        if(is_dir($dir)){
            $handle=opendir($dir);
            while(($file=readdir($handle)) !== false){
                if($file != '.' && $file != '..' ){
                    $name = trim($this->removeExtension($file));
                    $names = explode('-', $name);
                    $dName = trim($names[0]);
                    $cName = trim($names[1]);
                    $tName = trim($names[2]);
                    $newName = $dName . $tName;
                    $departmemt = Department::where('name', 'like', $dName . '%')->get();
                    if ($departmemt->count()) {
                        $d_id = $departmemt[0]->id;
                        $company = Company::where('name', $cName)->get();
                        if ($company->count()) {
                            $c_id = $company[0]->id;
                        }else{
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
                        $tran = Transportation::where('name', $newName)->get();
                        if ($tran->count()) {
                            $t_id = $tran[0]->id;
                        } else {
                            $TData = new Transportation();
                            $TData->name = $newName;
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
                        $i = 0;
                        $path = $dir . DIRECTORY_SEPARATOR . $file;
                        $collection = Excel::toCollection(new Device_Import_V_1_1(), $path);
                        $array = $collection->toArray();
                        foreach ($array[0] as $k=>$v){
                            if (trim($v[3]) == '监控点'){
                                $dName = trim($v[0]);
                                $cameraid = trim($v[1]);
                                $device = Device::where('cameraid', $cameraid)->get();
                                //print_r($device);
                                if (!$device->count()) {
                                    $newData['department_id'] = $d_id;
                                    $newData['cameraid'] = $cameraid;
                                    $newData['type'] = $type;
                                    $newData['dt_id'] = $t_id;
                                    $newData['name'] = $dName;
                                    $newData['nodeid'] = 1;
                                    $newData['models'] = '1';
                                    $newData['frequency'] = 0;
                                    $newData['direction'] = '北';
                                    $newData['url'] = 'rtsp://192.168.1.40/t5.mkv';
                                    $newData['updated_id'] = 0;
                                    //print_r($newData);
                                    if (Device::create($newData)) {
                                        $i++;
                                    }

                                }
                            }
                        }
                        echo($file.'导入设备：'.$i.'个----');
                    }else{
                        print_r($file.'组织机构不存在');
                    }

                }
            }
        }else{
            print_r($dir.'目录不存在');
        }
    }

    function extractExtension($fileName, $point=false){
        $result = strrchr($fileName, ".");
        if($point){
            $result = str_replace('.', '', $result);
        }
        return strtolower($result);
    }

    function removeExtension($fileName){
        return str_replace($this->extractExtension($fileName), "", $fileName);
    }


}


