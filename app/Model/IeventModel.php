<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class IeventModel extends Model
{
    protected $fillable = ['id','name'];

    public  $timestamps = false;

    protected $table = 'model_ievents';

    //获取模型名称
    public static function getModels()
    {
        $res = IeventModel::all()->mapWithKeys(function ($item) {
            return [$item['id'] => $item['name']];
        });
        return $res->toArray();
    }

}
