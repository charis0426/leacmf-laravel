<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AnalysisModel extends Model
{
    protected $fillable = ['id', 'models', 'e_count', 'e_hour', 'area'];

    public $timestamps = true;

    protected $table = 'model_trigger_condition';

    public function setCreatedAtAttribute($value)
    {
        // Do nothing.
    }

    //获取模型名称
    public static function getModels()
    {
        $res = AnalysisModel::all()->mapWithKeys(function ($item) {
            return [$item['id'] => $item['models']];
        });
        return $res->toArray();
    }

}
