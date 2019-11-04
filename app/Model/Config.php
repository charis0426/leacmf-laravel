<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $fillable = ['id','title','logo','video_url','auth_url','statistics_time','concurrency','numbers','page_size'];

    public  $timestamps = false;
}
