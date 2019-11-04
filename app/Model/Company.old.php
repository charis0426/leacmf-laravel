<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Company extends Model
{
    protected $fillable = ['id', 'name', 'position', 'head', 'phone', 'department_id',
        'last_time', 'licenses', 'code', 'brand_ids'];

    public  $timestamps = false;

    protected $table = 'supervision_companys';

    public function transportation()
    {
        return $this->hasOne('App\Model\Transportation', 'pid');
    }

    public function dot()
    {
        return $this->hasOne('App\Model\Dot', 'pid');
    }
}