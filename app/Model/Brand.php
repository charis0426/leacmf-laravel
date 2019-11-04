<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Brand extends Model
{
    protected $fillable = ['id', 'name', 'company', 'shorthand', 'trademark', 'description', 'department_id'];

    public  $timestamps = true;

    protected $table = 'supervision_brands';

    //获取部门名称
    public static function getBrand()
    {
        $res = Brand::all()->mapWithKeys(function ($item) {
            return [$item['id'] => $item['name']];
        });
        return $res->toArray();
    }

}