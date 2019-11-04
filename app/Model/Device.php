<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Device extends Model
{
    protected $fillable = ['id', 'name', 'models', 'frequency', 'time',
        'direction', 'cameraid', 'nodeid', 'url', 'updated_id', 'type', 'dt_id', 'department_id',
        'hkserverpara_id','event_update','event_flag'];

    public  $timestamps = true;

    public $table = 'analysis_configs';

    public static function DeviceList($where, $page_size, $offset){
        $data = array();

        return $data;
    }


}