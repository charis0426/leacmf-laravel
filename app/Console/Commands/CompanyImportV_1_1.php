<?php

namespace App\Console\Commands;

use App\Imports\Device_Import_V_1_1;
use App\Model\Company;
use App\Model\Department;
use App\Model\Device;
use App\Model\Transportation;
use Illuminate\Console\Command;
use Excel;

class CompanyImportV_1_1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'company_import_v_1_1 {--path=}';

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
        $i = 0;
        $j = 0;
        $path = $this->option('path');
        if (!is_file($path)) {
            print_r($path . '文件不存在');
            return;
        }
        $Collection = Excel::toCollection(new Device_Import_V_1_1(), $path);
        $array = $Collection->toArray();
        unset($array[0][0]);
        foreach ($array[0] as $k=>$v){
            //print_r($v);
            $departmemt = Department::where('name', 'like', trim($v[3].'%'))->get();
            if ($departmemt->count()) {
                $d_id = $departmemt[0]->id;
                $company = Company::where('name', trim($v[1]))->get();
                if ($company->count()) {
                    $c_id = $company[0]->id;
                } else {
                    $option = explode(',', trim($v[7]));
                    $cData = new Company();
                    $cData->name = trim($v[1]);
                    $cData->position = trim($v[4]);
                    $cData->head = trim($v[5]);
                    $cData->phone = trim($v[6]);
                    $cData->department_id = $d_id;
                    $cData->last_time = '0';
                    $cData->licenses = '0';
                    $cData->code = '0';
                    $cData->brand_ids = '0';
                    $cData->lnt = trim($option[0]);
                    $cData->lat = trim($option[1]);
                    //print_r($cData);
                    if ($cData->save()){
                        $i++;
                    }
                    $c_id = $cData->id;
                }
                $tran = Transportation::where('name', trim($v[2]))->get();
                if ($tran->count()){
                    $t_id = $tran[0]->id;
                }else{
                    $TData = new Transportation();
                    $TData->name = trim($v[2]);
                    $TData->position = trim($v[4]);
                    $TData->head = trim($v[5]);
                    $TData->phone = trim($v[6]);
                    $TData->department_id = $d_id;
                    $TData->last_time = '0';
                    $TData->licenses = '0';
                    $TData->pid = $c_id;
                    $TData->code = '0';
                    $TData->brand_ids = '0';
                    $TData->lnt = trim($option[0]);
                    $TData->lat = trim($option[1]);
                    //print_r($TData);
                    if ($TData->save()){
                        $j++;
                    }
                    $t_id = $TData->id;
                }
            }
        }
        print_r('成功导入企业'.$i.'个;成功导入转运中心'.$j.'个;');

    }


}


