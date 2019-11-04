<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Library\Help;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;

class TestController extends Controller
{
    public function __construct(){
        $this->log = new LogController();
    }

    public function createLog(){
        //$user_id = Auth::guard('admin')->user()->id;
        //for ($x=0; $x<=100; $x++) {
            //$user_id = rand(1,7);
            //$department_id = rand(1,7);
            //$type = 1;
            //$content = "删除用户";
            $this->log->create(1, '删除用户');
        //}
    }

    public function upload()
    {
        return view('admin.supervision.brand.index_list');
    }
}