<?php


namespace App\Imports;

use App\Model\Company;
use App\Model\Department;
use App\Model\DepartmentCache;
use App\Model\Device;
use App\Model\Transportation;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use App\Extensions\myapp\Jobs\ProductImportQueue;   // 队列
use App\Extensions\myapp\Models\Product;
use Maatwebsite\Excel\Row;

class DepartmentImport implements ToCollection {
    public $path;
    public function __construct($path) {
        $this->path = $path;
    }
    public function collection(Collection $rows) {
        // 缓存读取已导入数量
        // 循环导入100条
        // 若未导入完成，记录缓存，并重新创建队列 (或者重新执行队列？)
        // dispatch(new ProductImportQueue($this->path));
        $newData = array();
        $data = $rows->toArray();
        unset($data[0]);
        foreach ($data as $k =>$v){
            //print_r($cName.',');
            $govcode = substr($v[5], 0, 6);
            $departmemt = DB::select('SELECT * FROM `departments` where  FIND_IN_SET(?,govcode)', [$govcode]);
            $d_id = $departmemt[0]->id;
            if ($v[2]){
                $cName = $v[2];
                $c = Company::where('name', $cName)->get();
                if ($c->count()){
                    $c_id = $c[0]->id;
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
            }
            if ($v[3] && $v[4] == ''){
                $tName = $v[3];
                $t = Transportation::where('name', $tName)->get();
                if ($t->count()){
                    $t_id = $t[0]->id;
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
            }
            $newData[$k]['department_id'] = $d_id;
            $newData[$k]['cameraid'] = $v[5];
            $newData[$k]['type'] = 0;
            $newData[$k]['dt_id'] = $t_id;
            $newData[$k]['name'] = $v[6];
            $newData[$k]['nodeid'] = 1;
            $newData[$k]['models'] = '1';
            $newData[$k]['frequency'] = 0;
            $newData[$k]['direction'] = '北';
            $newData[$k]['url'] = 'rtsp://192.168.1.40/t5.mkv';
            $newData[$k]['updated_id'] = 0;
        }
        //print_r($newData);
        foreach ($newData as $n =>$d){

            Device::create($d);
        }
        /*foreach ($rows->toArray() as $k=>$v){
            if ($v[1] != ''){
                $data['name'] = $v[2];
                $data['shorthand'] = $v[3];
                $data['pid'] = 1;
                DepartmentCache::create($data);
            }
        }

        foreach ($rows->toArray() as $k=>$v){
            if ($v[1] == '' && $v[2] != ''){
                $ca = explode('-', $v[3]);
                $res = DepartmentCache::where('shorthand', $ca[0])->first();
                //print_r($res['id']);
                $data['name'] = $v[2];
                $data['shorthand'] = $v[3];
                $data['pid'] = $res['id'];
                //print_r($data);
                DepartmentCache::create($data);
            }
        }*/
    }
}