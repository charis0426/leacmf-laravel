<?php

namespace App\Http\Middleware;

use App\Library\Y;
use App\Model\DLog;
use Illuminate\Support\Facades\Log;
use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Auth\Factory as Auth;
use Spatie\Permission\Models\Permission;


class AdminAuth
{

    /**
     * auth
     * @var
     */
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * andle an incoming request.
     * @param $request
     * @param Closure $next
     * @param $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard)
    {
        $this->auth->shouldUse($guard);
        //无需验证的，直接过
        if ($request->is(...$this->except)) {
            return $next($request);
        }
        //未登录的，登录
        if (!$this->auth->check()) {
            if ($request->isMethod('ajax')) {
                return Y::error('登录已过期，请重新登录');
            } else {
                echo "<script>window.parent.location.href='/admin/login';</script>";
                die;
            }
        }
        //检查海康插件配置缓存是否失效
        if(!session('sys_hk_video')){
            $this->getHkVideoConfigInfo();
        }
        //检查权限
        if (!($this->auth->user()->hasRole('super admin') || $this->auth->user()->can(Route::currentRouteName()))) {
            if ($request->isMethod('ajax')) {
                return Y::error('登录已过期，请重新登录');
            } else {
                //return redirect(route('login'));
                return response()->view('admin.public.errorInfo',['info'=>'您没有访问权限']);
            }
        }
        //写入日志
        self::writeLog($request);

        //验证通过
        return $next($request);
    }

    public function writeLog($request)
    {
        $path = $request->route()->getName();  //操作的路由
        $permission = Permission::where('name', $path)->first();
        if ($permission) {
            $data['type'] = $permission['title'];
            $data['content'] = json_encode($request->all()); //操作的内容
            $data['ip'] = $request->ip(); //操作的IP
            $data['method'] = $request->method(); //请求方式
            $data['nick_name'] = $this->auth->user()->nickname;
            $data['department_id'] = $this->auth->user()->group_id;
            DLog::create($data);
        }
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
        'admin/login',
        'admin/logout',
        'admin/device/vdconfig',
        'admin/transportation/list/user',
    ];

}
