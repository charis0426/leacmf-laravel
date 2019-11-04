<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PDevice extends Model
{
    protected $fillable = ['id', 'name', 'cameraid', 'user_id', 'pid'];

    public  $timestamps = false;

    protected $table = 'point_devices';




}