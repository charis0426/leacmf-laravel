<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Version extends Model
{
    protected $fillable = ['id', 'version', 'description', 'file_path'];

    //重写setUpdatedAt方法
    public function setUpdatedAt($value) {

        // Do nothing.

    }


}