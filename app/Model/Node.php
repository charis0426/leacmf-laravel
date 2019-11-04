<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Node extends Model
{
    protected $fillable = ['id', 'ip', 'position', 'department_id', 'status',
        'versions', 'token', 'cpu_use', 'mem_use', 'disk_use'];

    public  $timestamps = false;

    public static function NodeList($where, $page_size, $offset){
        $data = array();

        return $data;
    }

}