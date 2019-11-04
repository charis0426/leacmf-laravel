<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Model\Config;
use GuzzleHttp\Client;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /*
     * 判断用户单位所属 国家(0)，省(1)，市(2),查询失败/异常(3),不传入参数默认查询当前登录用户组织关系
     * @param none
     * @return int
     */
    public function checkDepartment($group_id = "")
    {
        if ($group_id == "") {
            $group_id = Auth::guard('admin')->user()->group_id;
        }
        try {
            $res = DB::table('departments')->where('id', $group_id)->get();
        } catch (\Exception $e) {
            Log::error($e);
            return 3;
        }
        if ($res->count()) {
            if ($res[0]->pid == 0) {
                #国家
                return 0;
            } else if ($res[0]->pid == 1) {
                #省级
                return 1;
            }
            #市级
            return 2;
        }
        return 3;

    }

    /*
     * 登录成功后获取websocket通讯令牌
     * @param $user,$password
     * @return none
     */
    public function getSocketToken($user, $password)
    {
        $client = new Client();
        try {
            $response = $client->request("GET", config("param.get_st_api") . $user[0]['username'] . "_" . $password,
                ['headers' => ['Content-type' => 'application/json']]);
            $code = $response->getStatusCode();
            $res = json_decode($response->getBody()->getContents());
            if ($code == "200" && $res->ErrCode == "0") {
                Log::info($res->Authorization);
                #缓存websocket的令牌token
                //session(['socket_token' => $res->Authorization]);
                session(['socket_adr' => config('param.socket_adr') . $res->Authorization]);
            }
        } catch (\Exception $e) {
            Log::error($e);
            Log::info("登录成功后获取websocket通讯令牌失败");
        }
        Log::info("sdasdscfdsggg");
    }

    /*
     * 获取配置，缓存信息
     * @param none
     * @return none
     */
    public function getSysConfigInfo()
    {
        try {
            $res = Config::all();
            if ($res->count()) {
                $config = $res[0];
                session(['sys_config' => $config]);
            } else {
                Log::info("系统配置信息为空");
            }
        } catch (\Exception $e) {
            Log::error($e);
            Log::info("系统配置信息读取失败");
        }
    }

    /*
     * 访问节点api接口通用同步方法封装
     * @param type:方法类型,data:数据结合
     * @return boolean/object
     */
    public function request($type = "POST", $url, $data = [])
    {
        $client = new Client();
        try {
            $response = $client->request($type, config('param.node_adr') . $url,
                ['headers' => ['Content-type' => 'application/json'],
                    'body' => json_encode($data)]);
            $code = $response->getStatusCode();
            $res = json_decode($response->getBody()->getContents());
        } catch (\Exception $e) {
            Log::error($e);
            return false;
        }
        Log::info(json_encode($res));
        if ($code == "200" && $res->ErrCode == "0") {
            return $res;
        }
        return false;
    }

    /*
    * 获取海康视频插件配置，缓存信息
    * @param none
    * @return none
    */
    public function getHkVideoConfigInfo()
    {
        try {
            $info = config("param.hk_video_config");
            if ($info) {
                session(['sys_hk_video' => $info]);
                return $info;
            } else {
                Log::info("海康视频插件配置去读失败");
            }
        } catch (\Exception $e) {
            Log::error($e);
            Log::info("海康视频插件配置去读异常");
        }
    }
}
