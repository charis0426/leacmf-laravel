<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Config;
use App\Library\Y;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
class ConfigController extends Controller
{
    /*
     *
     * 系统配置信息
     * @param Request $request
     * @return view or json
     */
     public function  index(Request $request){
         if ($request->isMethod('post')) {
             #验证数据合法性
             $post      = $request->post();
             Log::debug($post);
             $validator = Validator::make($post, [
                 'title'             => 'required|string',
                 'video_url'         => 'string',
                 'record_num'        => 'string',
                 'auth_url'          => 'string',
                 'copyright_info'    => 'string',
                 'status'            => 'int|min:0|max:2'
             ],[],[
                 'title'             => '平台名称',
                 'record_num'        => 'ICP备案序号',
                 'video_url'         => '视频联网平台地址',
                 'copyright_info'    => '版权信息',
                 'status'            => '网站状态',
             ]);
             if ($validator->fails()) {
                 return Y::error($validator->errors());
             }
             #查询是否已经存在配置信息
             $res = Config::all();
             if($res->count()){
                 #执行更新操作
                 try{
                     $result = Config::where("id",$res[0]->id)->update($post);
                 } catch (\Exception $e){
                     Log::error($e);
                     return Y::error("配置失败");
                 }
                 if($result){
                     #配置成功后，缓存系统基础信息
                     session(['sys_config'=>$post]);
                     Log::info("基础信息修改成功");
                     return Y::success("配置成功");
                 }
                 return Y::error("配置未做修改");
             }
             #未配置,添加配置
             try {
                 $result = Config::create($post);
             } catch (\Exception $e) {
                 Log::error($e);
                 return Y::error("配置失败");
             }
             if($result){
                 #配置成功后，缓存系统基础信息
                 session(['sys_config'=>$post]);
                 Log::info("基础信息首次配置成功");
                 return Y::success("配置成功");
             }
             return Y::error("配置失败");
         }
         #查询配置信息返回模版
         $res = Config::all();
         if($res->count()){
             $list = $res[0];
         }else{
             $list = '';
         }
         return view('admin.config.index',["list"=>$list]);
     }


}
