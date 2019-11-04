<?php

namespace App\Console\Commands;

use App\Model\Admin;
use App\Model\AnalysisConfig;
use App\Model\AnalysisModel;
use App\Model\Company;
use App\Model\Department;
use App\Model\Device;
use App\Model\Dot;
use App\Model\IeventModel;
use App\Model\Task;
use App\Model\Transportation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class StatisticalDevice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statistical-device';

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
        //统计转运中心设备数量
        $this->CountTDevice();
        //统计网点设备数量
        $this->CountDDevice();
    }

    //统计转运中心设备数量
    private function CountTDevice(){
        //查询转运中心列表
        $list = Transportation::select('id', 'device_count')->get()->toarray();
        //print_r($list);exit();
        foreach ($list as $k=>$v){
            $count = Device::where('type', 0)->where('dt_id', $v['id'])->count();
            if ($count != $v['device_count']){
                Transportation::where('id', $v['id'])->update(['device_count'=>$count]);
            }
        }
    }

    //统计转运中心设备数量
    private function CountDDevice(){
        //查询转运中心列表
        $list = Dot::select('id', 'device_count')->get()->toarray();
        //print_r($list);exit();
        foreach ($list as $k=>$v){
            $count = Device::where('type', 1)->where('dt_id', $v['id'])->count();
            if ($count != $v['device_count']){
                //print_r($count);
                Dot::where('id', $v['id'])->update(['device_count'=>$count]);
            }
        }
    }


}


