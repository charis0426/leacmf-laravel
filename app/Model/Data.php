<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Data extends Model
{
    protected $fillable = ['id', 'description', 'type', 'title', 'path', 'created_at'];

    public  $timestamps = true;

    public $table = 'backups';

    public function setUpdatedAtAttribute($value) {
        // Do nothing.
    }


}