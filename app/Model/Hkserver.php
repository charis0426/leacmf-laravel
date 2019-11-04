<?php
/**
 * Created by PhpStorm.
 * User: hewei
 * Date: 2019/10/16
 * Time: 9:53 AM
 */


namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Hkserver extends Model
{
    protected $fillable = ['id', 'appkey', 'appsecret', 'artemisip', 'artemisport','department_id'];

    public $timestamps = true;

    protected $table = 'hk_server_para';


}
