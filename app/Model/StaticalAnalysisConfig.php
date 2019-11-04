<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StaticalAnalysisConfig extends Model
{
    protected $fillable = ['id','number','type','department_id','time'];
}
