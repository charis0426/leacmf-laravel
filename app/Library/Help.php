<?php
/**
 * Created by PhpStorm.
 * User: lea
 * Date: 2017/12/13
 * Time: 下午3:28
 */

namespace App\Library;

class Help
{
    //获取分页
    public static function offset($page_size, $page = 1){
        $offset = ($page - 1) * $page_size;
        return $offset;
    }
}