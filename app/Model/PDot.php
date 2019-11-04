<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PDot extends Model
{
    protected $fillable = ['id', 'd_id', 'department_id'];

    public  $timestamps = true;

    protected $table = 'point_dots';

    public function dot()
    {
        return $this->belongsTo('App\Model\Dot', 'd_id');
    }

    public function device()
    {
        return $this->hasMany('App\Model\Device', 'dt_id');
    }

}