<?php
/**
 * Created by PhpStorm.
 * User: xnKang
 * Date: 2019/10/21
 * Time: 10:29 AM
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class PlayController extends Controller
{

    /*
     * 展示页面监管对象首页
     */
    public function index(){
        $id = Auth::guard('admin')->user()->group_id;
        return view('admin.index.new_index',['id'=>$id]);
    }
    /*
     * 展示页面智能分分析页面
     */
    public function aevent(){
        $id = Auth::guard('admin')->user()->group_id;
        return view('admin.index.aevent',['id'=>$id]);
    }
    
    /*
     * 展示页面智能分分析页面
     */
    public function ievent(){
        $id = Auth::guard('admin')->user()->group_id;
        return view('admin.index.ievent',['id'=>$id]);
    }
/*
     * 展示页面智能分分析页面
     */
    public function play(){
        echo "aaaaaaaaaaaa";
    }
}