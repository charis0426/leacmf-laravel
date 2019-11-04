<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FileLog extends Model
{
    protected $fillable = ['id', 'name', 'file', 'created_at', 'updated_at'];

    public  $timestamps = true;

    public $table = 'file_logs';

}