<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PCompany extends Model
{
    protected $fillable = ['id', 'c_id', 'department_id'];

    public  $timestamps = true;

    protected $table = 'point_companys';


    public function company()
    {
        return $this->belongsTo('App\Model\Company', 'pid');
    }


}