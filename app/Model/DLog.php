<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DLog extends Model
{
    protected $fillable = ['id', 'department_id', 'type', 'content', 'nick_name', 'method', 'ip', 'created_at'];

    public  $timestamps = true;

    public $table = 'logs';

    public function setUpdatedAtAttribute($value) {
        // Do nothing.
    }

    public static function logList($where, $table, $page_size, $offset){
        $data = array();
        $record = DB::table($table)
            ->whereRaw($where)
            -> orderBy('id', 'desc')
            ->skip($offset)->take($page_size)->get()->toArray();
        $count = DB::table($table)
            ->whereRaw($where)
            ->count();
        $data = array_add($data, 'data', $record);
        $data = array_add($data, 'total', $count);
        return $data;
    }

    public static function logDown($where, $table){
        $record = DB::table($table)
            ->whereRaw($where)
            -> orderBy('id', 'desc')
            ->get();
        return $record;
    }

    public static function createTable($table){
        $sql = "CREATE TABLE `".$table."` (
                  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                  `department_id` int(11) NOT NULL,
                  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
                  `nick_name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
                  `ip` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
                  `method` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
                  `created_at` timestamp NOT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        return DB::statement($sql);
    }

    public static function createData($table, $data){
        return DB::table($table)->insert($data);
    }

    public static function dropTable($table){
        return DB::statement("DROP TABLE " . $table);
    }

}