<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Dot extends Model
{
    protected $fillable = ['id', 'name', 'position', 'head', 'phone',
        'department_id', 'brand_ids', 'pid', 'level', 'work_time', 'lat', 'lnt','device_count'];

    public  $timestamps = false;

    protected $table = 'supervision_dots';

    public function device()
    {
        return $this->hasMany('App\Model\Device', 'dt_id');
    }

}