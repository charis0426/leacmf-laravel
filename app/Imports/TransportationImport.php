<?php
namespace App\Imports;

use App\Model\Transportation;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class TransportationImport implements ToCollection
{
    public $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function collection(Collection $rows)
    {
        $code = json_decode(file_get_contents(base_path() . DIRECTORY_SEPARATOR . 'code'), true);
        //print_r($code);
        $newData = array();
        $data = $rows->toArray();
        unset($data[0]);
        //print_r($data);
        foreach ($data as $k =>$v){
            if (trim($v[3]) == '组织') {
                $tname = trim($v[0]);
                $str=preg_replace('/[^0-9 ]/i','',$tname);
                $codeIndex = '0' . substr(trim($str), 0, 3);
                if (array_key_exists($codeIndex, $code)) {
                    $name = $code[$codeIndex];
                    $t = Transportation::where('name', $tname)->get();
                    if (!$t->count()) {
                        $sql = "select * from `departments` where `name` like '" . $name . "%'";
                        $departmemt = DB::select($sql);
                        if (!empty($departmemt)) {
                            $d_id = $departmemt[0]->id;
                            //print_r($d_id.'/');
                            $TData = new Transportation();
                            $TData->name = $tname;
                            $TData->position = '0';
                            $TData->head = '0';
                            $TData->phone = '0';
                            $TData->department_id = $d_id;
                            $TData->last_time = '0';
                            $TData->licenses = '0';
                            $TData->pid = 0;
                            $TData->code = '0';
                            $TData->brand_ids = '0';
                            $TData->lnt = '0';
                            $TData->lat = '0';
                            $TData->save();
                        }
                    }
                }
            }

        }

    }
}