<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transportation extends Model
{
    protected $fillable = ['id', 'name', 'position', 'head', 'phone', 'department_id',
        'last_time', 'licenses', 'code', 'brand_ids', 'pid', 'device_count'];

    public  $timestamps = false;

    protected $table = 'supervision_transportations';

    public function device()
    {
        return $this->hasMany('App\Model\Device', 'dt_id');
    }

}