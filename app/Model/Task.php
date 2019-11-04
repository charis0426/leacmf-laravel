<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['id','name','start_time','end_time','department_ids','company_ids',
        'transportation_ids', 'dot_ids', 'devices_count', 'ievents', 'aevents', 'status', 'content',
        'user_id', 'type'];

    public  $timestamps = true;

    public function setUpdatedAtAttribute($value) {
        // Do nothing.
    }

    public $table = 'statistical_tasks';
}
