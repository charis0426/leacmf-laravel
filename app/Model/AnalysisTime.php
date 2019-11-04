<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AnalysisTime extends Model
{
    protected $fillable = ['id','start_time','end_time','type', 'department_id'];

    public  $timestamps = false;

    protected $table = 'supervise_time';


}
