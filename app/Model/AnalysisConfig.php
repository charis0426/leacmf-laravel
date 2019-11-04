<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AnalysisConfig extends Model
{
    protected $fillable = ['id','models','frequency','start_time','end_time','cameraid','nodeid','url'];

}
