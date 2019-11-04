<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $fillable = ['id','title','type','priority','status','created_at'];
}
