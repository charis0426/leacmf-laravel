<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Aevent extends Model
{
    protected $fillable = ['id', 'event_type', 'department_id', 'cameraid', 'cameraname', 'object',
        'type', 'dt_id', 'node_id', 'pid', 'pic_node_path', 'pic_name', 'pic_exist'];

    protected $connection = 'aevent';

    protected $table = 'analysis_events_';

    public  $timestamps = true;


    public function setUpdatedAtAttribute($value) {
        // Do nothing.
    }

    public static function  aeventList($group_id, $offset, $page_size)
    {
        $table = 'analysis_events_' . $group_id;
        $data = array();
        $record = DB::connection('aevent')->table($table)

            -> orderBy('id', 'desc')
            ->skip($offset)->take($page_size)->select('*')->get()->toArray();
        $count = DB::connection('aevent')->table($table)
            //->whereRaw($where)
            ->count();
        $data = array_add($data, 'data', $record);
        $data = array_add($data, 'total', $count);
        //return $data;
        print_r($data);
        exit();
    }

    public function transportation()
    {
        return $this->hasOne('App\Model\Transportation', 'pid');
    }

    public function dot()
    {
        return $this->hasOne('App\Model\Dot', 'pid');
    }
}