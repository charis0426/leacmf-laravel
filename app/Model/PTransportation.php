<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PTransportation extends Model
{
    protected $fillable = ['id', 't_id', 'department_id'];

    public  $timestamps = true;

    protected $table = 'point_transportations';



}