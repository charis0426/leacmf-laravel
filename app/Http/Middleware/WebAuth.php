<?php
/**
 * Created by PhpStorm.
 * User: hewei
 * Date: 2019/10/21
 * Time: 10:04
 */

namespace App\Http\Middleware;
use Illuminate\Contracts\Auth\Factory as Auth;
use Closure;

class WebAuth
{

    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$guard = 'admin')
    {
        $this->auth->shouldUse($guard);
        #无需验证的，直接过
        if ($request->is(...$this->except)) {
            return $next($request);
        }
        //检查海康插件配置缓存是否失效
        if(!session('sys_hk_video')){
            $this->getHkVideoConfigInfo();
        }
        #未登录的，登录
        if (!$this->auth->check()) {
            echo "<script>window.parent.location.href='/admin/login';</script>";
            die;
        }
        if(!session('socket_adr')){
            return response()->view('admin.public.errorInfo',['info'=>'请检查socket认证服务是否正常和开启!']);
        }
        //dd($request);die;
        return $next($request);
    }
    /*
    * 获取海康视频插件配置，缓存信息
    * @param none
    * @return none
    */
    public function getHkVideoConfigInfo(){
        try{
            $info  = config("param.hk_video_config");
            if($info){
                session(['sys_hk_video'=>$info]);
            }else{
                Log::info("海康视频插件配置去读失败");
            }
        } catch (\Exception $e){
            Log::error($e);
            Log::info("海康视频插件配置去读异常");
        }
    }
    protected $except = [

    ];
}
