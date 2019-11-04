<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Department extends Model
{
    protected $fillable = ['id', 'name', 'pid', 'govcode'];

    public  $timestamps = false;
    protected $table = 'departments';

    //获取部门的pid
    public static function getPid($id)
    {
        $pid = Department::where('id', $id)->first()->toarray();
        return $pid['pid'];
    }

    //根据pid获取组织结构id集合
    public static function getIdByPid($pid)
    {
        $id = Department::where('pid', $pid)->pluck('id')->toarray();
        return $id;
    }

    //获取部门名称
    public static function getDepartment()
    {
        $res = Department::all()->mapWithKeys(function ($item) {
            return [$item['id'] => $item['name']];
        });
        return $res->toArray();
    }

}