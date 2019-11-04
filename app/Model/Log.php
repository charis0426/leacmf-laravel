<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Log extends Model
{
    protected $fillable = ['id', 'department_id', 'type', 'content', 'user_id', 'created_at'];

    public  $timestamps = false;

    public static function logList(){
        /*$record = DB::table('logs')
            ->Leftjoin('admins', 'admins.id', '=', 'logs.user_id')
            ->where('department_id', '=', '0')
            ->select('logs.*', 'admins.username')
            ->paginate(15);
        */

        return $record;
    }

}