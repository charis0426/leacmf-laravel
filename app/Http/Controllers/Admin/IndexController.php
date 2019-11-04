<?php
/**
 * Created by PhpStorm.
 * User: hewei
 * Date: 2019/3/1
 * Time: 14:04
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Y;
use App\Model\AnalysisModelContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Model\AnalysisConfig;
use App\Model\Hkserver;
class IndexController extends Controller
{
    //首页模版
    public function shouye(){
         #判断缓存是否过期
         if(!session('sys_config')){
             $res = $this->getSysConfigInfo();
         }else{
             $res = session('sys_config');
         }
        return view('admin.layout',['config'=>$res]);
    }



    //首页控制台
    public function index()
    {
        return view('admin.index.index');
    }

    public function flexible(Request $request)
    {
        session(['menu_status' => $request->get('menu', 'open')]);
    }

    /**
     * 获取系统信息
     * @return mixed
     */
    protected function getServerInfo()
    {
        $sys_info['os']           = PHP_OS;
        $sys_info['zlib']         = function_exists('gzclose') ? 'YES' : 'NO'; //zlib
        $sys_info['safe_mode']    = (boolean)ini_get('safe_mode') ? 'YES' : 'NO'; //safe_mode = Off
        $sys_info['timezone']     = function_exists("date_default_timezone_get") ? date_default_timezone_get() : "no_timezone";
        $sys_info['curl']         = function_exists('curl_init') ? 'YES' : 'NO';
        $sys_info['web_server']   = $_SERVER['SERVER_SOFTWARE'];
        $sys_info['phpv']         = phpversion();
        $sys_info['ip']           = GetHostByName($_SERVER['SERVER_NAME']);
        $sys_info['fileupload']   = @ini_get('file_uploads') ? ini_get('upload_max_filesize') : 'unknown';
        $sys_info['max_ex_time']  = @ini_get("max_execution_time") . 's'; //脚本最大执行时间
        $sys_info['domain']       = $_SERVER['HTTP_HOST'];
        $sys_info['memory_limit'] = ini_get('memory_limit');
        $dbPort                   = Config::get('database.prefix');
        $dbHost                   = Config::get('database.prefix');
        $dbHost                   = empty($dbPort) || $dbPort == 3306 ? $dbHost : $dbHost . ':' . $dbPort;

        $musql_version             = DB::select('select version() as ver');
        $sys_info['mysql_version'] = $musql_version[0]->ver;
        if (function_exists("gd_info")) {
            $gd                 = gd_info();
            $sys_info['gdinfo'] = $gd['GD Version'];
        } else {
            $sys_info['gdinfo'] = "未知";
        }

        return $sys_info;
    }

    //清空缓存
    public function flush()
    {
        Cache::flush();
        return Y::success('缓存已清除');
    }
    /*
     * 查询当前设备的组织结构返回服务中心的appkey
     * @return \Illuminate\Http\Response
     */
    public function getHkServerConfig(Request $request)
    {
        #判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->post();
            Log::debug($post);
            $validator = Validator::make($post, [
                'cameraid' => 'required|string'
            ], [], [
                'cameraid' => '设备编号',
            ]);
            if ($validator->fails()) {
                return Y::error($validator->errors());
            }
            #获取海康部分配置
            if(!session('sys_hk_video')){
                $config = $this->getHkVideoConfigInfo();
            }else{
                $config = session('sys_hk_video');
            }
            #获取改设备号的组织结构
            try {
                $map = AnalysisConfig::where('analysis_configs.cameraid', '=', $post['cameraid'])
                    ->leftJoin('hk_server_para', 'hk_server_para.id',
                        '=', 'analysis_configs.hkwebpara_id')->select('hk_server_para.*', 'analysis_configs.cameraid')
                    ->get()->toarray();
            } catch (\Exception $e) {
                Log::error($e);
                Log::info($post['cameraid']."设备查询所属服务中心配置失败");
                return Y::error("查询失败");
            }
            if(count($map) <= 0){
                Log::info($post['cameraid']."设备查询所属服务中心配置为空");
                return Y::error("查询失败");
            }
            #组装cameraid
            $map[0]['cameraid'] = $post['cameraid'];
            #追加部分参数
            $res = array_merge($map[0],$config);
            return Y::success("查询成功",$res);
        }
    }
    /*.
     * 通过设备编号查询到设备内码
     * @return \Illuminate\Http\Response
     */
    public function getDeviceEncoding(Request $request){
        #判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->post();
            Log::debug($post);
            $validator = Validator::make($post, [
                'cameraid' => 'required|string'
            ], [], [
                'cameraid' => '设备编号',
            ]);
            if ($validator->fails()) {
                return Y::error($validator->errors());
            }
            #调用底层控制器方法获取内码
            $map['CameraIndexCode'] = $post['cameraid'];
            $res  = $this->request('POST','indexCode/find',$map);
            if(!$res || $res->ErrCode != 0 ||$res->CameraIndexCode == ""){
                Log::info("未查询到设备".$post['cameraid']."内码");
                $cameraId = $post['cameraid'];
            }else{
                $cameraId = $res->CameraIndexCode;
            }
            return Y::success("查询成功",['CameraIndexCode'=>$cameraId]);
        }
    }

}