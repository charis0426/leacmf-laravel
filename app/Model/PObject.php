<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PObject extends Model
{
    protected $fillable = ['id', 'name', 'type', 'department_id', 'pid', 'cause'];

    public  $timestamps = true;

    protected $table = 'point_objects';

    public function setUpdatedAtAttribute($value) {
        // Do nothing.
    }



}