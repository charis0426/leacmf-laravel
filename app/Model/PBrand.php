<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PBrand extends Model
{
    protected $fillable = ['id', 'b_id'];

    public  $timestamps = true;

    protected $table = 'point_brands';

    public function dot()
    {
        return $this->belongsTo('App\Model\Dot', 'd_id');
    }

    public function device()
    {
        return $this->hasMany('App\Model\Device', 'dt_id');
    }

}