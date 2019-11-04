<?php
/**
 * Created by PhpStorm.
 * User: hewei
 * Date: 2019/2/26
 * Time: 14:51
 */

namespace app\Http\Controllers\Admin;

use App\Events\BlogView;
use App\Http\Controllers\Controller;
use App\Library\Y;
use App\Model\Admin;
use App\Model\DLog;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use App\Service\Sms;
use App\Service\Email;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Notifications\InvoicePaid;
class PublicController extends Controller
{

     /*
     * 登录
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $post      = $request->only(['email', 'mobile', 'password', 'captcha']);
            Log::debug($post);
            $validator = Validator::make($post, [
                'email'    => 'string|email|max:255',
                'mobile'   => 'regex:/^1[34578][0-9]{9}$/',
                'password' => 'required|min:6|max:16',
                'captcha'  => 'required|captcha'
            ],  [],  [
                'captcha' => '验证码',
                'email'   => '邮箱',
                'mobile'  => '手机号码'
            ]);
            if ($validator->fails()) {
                return Y::error($validator->errors()->first());
            }
            unset($post['captcha']);
            #判断当前用户是否被禁用
            if(isset($post['email'])&&$post['email']!='') {
                $user = Admin::where('email', $post['email'])->get();
            }else if(isset($post['mobile'])&&$post['mobile']!=''){
                $user = Admin::where('mobile', $post['mobile'])->get();
            }else{
                return Y::error('请填写正确的用户邮箱/手机号');
            }
            if($user->count() && $user[0]->status == 1){
                return Y::error('当前用户已被禁用,请联系管理员');
            }else if(!$user->count()){
                return Y::error('用户不存在，请重新输入');
            }
            if (Auth::guard('admin')->attempt($post, boolval($request->post('remember', '')))) {
                #获取socket通讯令牌
                $this->getSocketToken($user,$post['password']);
                Log::info("用户".$user[0]->username."登录成功");
                //写日志
                $data['content'] = json_encode($request->all()); //操作的内容
                $data['ip'] = $request->ip(); //操作的IP
                $data['method'] = $request->method(); //请求方式
                $data['nick_name'] = Auth::guard('admin')->user()->username;
                $data['department_id'] = Auth::guard('admin')->user()->group_id;
                $data['type'] = '登录';
                DLog::create($data);
                //return Y::success('登录成功', [], route('shouye'));
                return Y::success('登录成功', [], '/');
            }
            return Y::error('用户验证失败');
        } else {
            if (Auth::guard('admin')->check()) {
                return redirect()->route('shouye');
            }
            return view('admin.public.login');
        }
    }

    /*
     * 退出
     * @param Request $request
     * @return mixed
     */
    public function logout(Request $request)
    {
        if(Auth::guard('admin')->user() != null) {
            //写日志
            $data['content'] = json_encode($request->all()); //操作的内容
            $data['ip'] = $request->ip(); //操作的IP
            $data['method'] = $request->method(); //请求方式
            $data['nick_name'] = Auth::guard('admin')->user()->nickname;
            $data['department_id'] = Auth::guard('admin')->user()->group_id;
            $data['type'] = '退出';
            DLog::create($data);
        }
        auth()->logout();
        return redirect()->route('login');
    }

    /*
     * 邮箱找回密码
     * @param Request $request
     * @return mixed
     */
    public function recoverPass(Request $request,$token="",$type=0){
        if ($request->isMethod('post')) {
            #接受id,用户名，新的密码
            $post      = $request->only(['password', 'confirmPassword']);
            Log::debug($post);
            $validator = Validator::make($post, [
                'password' => 'required|min:6|max:16',
                'confirmPassword' => 'required|min:6|max:16'
            ], [
            ],["password"=>"新密码","confirmPassword"=>"确认密码"]);
            if ($validator->fails()) {
                return Y::error($validator->errors()->first());
            }
            #验证新密码和确认密码是否一致
            if($post['password'] != $post['confirmPassword']){
                return Y::error('新密码和确认密码不一致');
            }
            #验证当前token是否有效
            if($token != "" && Cache::has($token)){
                $key = Cache::get($token);
                #加密密码，更新数据库
                $password = bcrypt($post['password']);
                #判断当前修改用户是否存在
                if($type == 0) {
                    $where = 'email';
                }else{
                    $where = 'mobile';
                }
                $admin = Admin::where($where, $key)->get();
                if($admin->count()){
                    #执行修改时，返回修改结果
                    $data['password'] = $password;
                    $res = Admin::where($where,$key)->update($data);
                    if($res){
                        Log::info("找回密码成功");
                        return Y::success('找回密码成功,正在为您跳转',[],route('login'));
                    }
                    return Y::error('找回密码失败');
                }
                return Y::error('该用户不存在');
            }
            return Y::error('当前链接失效/无效,正在为您跳转',[],route('backpass'));
        }else{
            #获取找回密码的token
            if($token != "" && cache()->has($token)){
                #获取session来获取id和用户名
                $username = cache()->get($token);
                #返回到模版当前用户
                return view('admin.public.recovePass', ["username" => $username]);
            }
            return view('admin.public.expiredPage',['info'=>'当前链接无效或已过期','url'=>route('backpass')]);
        }
    }



    /*
     * 验证短信验证码
     */
    public function checkCode(Request $request){
        if ($request->isMethod('post')) {
            $post = $request->only('mobile','code');
            $validator = Validator::make($post, [
                'code'    => 'int|min:100000|max:999999',
                'mobile'   => 'regex:/^1[34578][0-9]{9}$/',
            ], [],["code"=>"短信验证码不正确","mobile"=>"手机号码不正确"]);
            if ($validator->fails()) {
                return Y::error($validator->errors()->first());
            }
            #验证验证码合法和正确
            $ret = Sms::check($post['mobile'], 'cv_pass', $post['code']);
            if($ret != ''){
                return Y::error($ret);
            }
            #验证成功，生产token,返回修改密码页面
            $token = sha1('sms_curl_token' . $post['mobile']);
            #缓存5分钟过期
            cache()->set($token,$post['mobile'],'5');
            return Y::success('验证成功，正在跳转修改密码页面',[],
                route('recoverpass',['token'=>$token,'type'=>1]));
        }
    }

    /*
     * 随机验证码输入是否正确，生成过期限制的token
     */
    public function checkCaptcha(Request $request){
        if($request->isMethod('post')) {
            #接收邮箱和用户名
            $post = $request->only(['mobile', 'email','captcha']);
            $validator = Validator::make($post, [
                'email' => 'string|email|max:255',
                'mobile' => 'regex:/^1[34578][0-9]{9}$/',
                'captcha'  => 'required|captcha'
            ],[],['captcha'=>'验证码']);
            if ($validator->fails()) {
                return Y::error($validator->errors()->first());
            }
            #验证手机/邮件是否存在
            if(isset($post['email'])&&$post['email']!='') {
                $user = Admin::where('email', $post['email'])->get();
                $map['key'] = $post['email'];
                $map['type'] = 0;
            }else if(isset($post['mobile'])&&$post['mobile']!=''){
                $user = Admin::where('mobile', $post['mobile'])->get();
                $map['key']= $post['mobile'];
                $map['type'] = 1;
            }else{
                return Y::error('请填写正确的用户邮箱/手机号');
            }
            if($user->count() && $user[0]->status == 1){
                return Y::error('当前用户已被禁用,不允许找回密码');
            }else if(!$user->count()){
                return Y::error('用户不存在，请重新输入邮箱/手机号');
            }
            #生产token,缓存找回密码账号信息
            $token = sha1('back_pass_token' . $map['key'].$map['type']);
            #缓存5分钟过期
            cache()->set($token,$map,'50');
            Log::info("找回密码验证码验证通过");
            return Y::success("验证通过正在跳转",[],route('checkidentity',['token'=>$token]));

        }
        return view('admin.public.backPass');
    }

    /*
     * 点击找回密码
     * @param Request $request
     * @return mixed
     */
    public function ckRvPass(Request $request,$token=""){
        if($request->isMethod('post')){
            #获取邮箱/手机号
            if(!cache()->get($token)||$token=="") {
                return Y::error('当前操作已过期，正在为你跳转',[],route('backpass'));
            }
            $data = cache()->get($token);
            #判断找回密码方式的是手机号还是邮箱
            if($data['key']!=''&&$data['type']==0) {
                $admin = Admin::where('email',$data['key'])->get();
            }else if($data['key']!=''&&$data['type']==1){
                $admin = Admin::where('mobile',$data['key'])->get();
            }else{
                return Y::error('当前链接失效/无效,正在为您跳转',[],route('backpass'));
            }
            if($admin->count()){
                #邮箱找回
                if($data['type'] == 0){
                    #是？加密生产token,用token作为缓存的key,value保存用户的用户名
                    $email_token = encrypt(time() . $admin[0]->email);
                    #缓存5分钟过期
                    Cache()->set($email_token, $admin[0]->email, "5");
                    #发送邮件
                    if (Email::sendMail($admin[0]['email'], $email_token,"找回密码")) {
                        Log::info("邮件发送成功");
                        return Y::success("邮件发送成功",[],route('backinfo',['token'=>$token]));
                    }
                    return Y::error("邮件发送失败");
                }
                #短信找回
                else if($data['type'] == 1){
                    if(Sms::sendCode($data['key'], $type = 'cv_pass')){
                        Log::info("验证短信发送成功");
                        return Y::success("验证短信发送成功",[],route('backinfo',['token'=>$token]));
                    }
                    return Y::error("验证短信发送失败");
                }
            }
            return Y::error("没有当前找回密码的用户");
        }else{
            #验证token是否合法和过期
            if(cache()->get($token)&&$token!="") {
                $data = cache()->get($token);
                #返回找回密码页面,输入账号、邮箱，点击提交
                return view('admin.public.ckRvPass', ['key' => $data['key'], 'type' => $data['type']]);
            }
            return view('admin.public.expiredPage',['info'=>'当前链接无效或已过期','url'=>route('backpass')]);
        }
    }
    /*
     * 邮件短信发送成功，提示页面
     */
    public function backPssInfo(Request $request,$token){
        #获取当前找回密码的账号和类型
        if(!cache()->get($token)||$token=="") {
            return view('admin.public.expiredPage',['info'=>'当前链接无效或已过期','url'=>route('backpass')]);
        }
        $data = cache()->get($token);
        if($data['type'] == 0){
            #邮箱方式
            return view('admin.public.ckEmailInfo',['email'=>$data['key']]);
        }
        else if($data['type'] == 1){
            #短信方式
            return view('admin.public.ckMobileInfo',['mobile'=>$data['key']]);
        }
    }

   #发送短信方法
//   public function sendSms($phone="18780246630"){
//       $randCode = rand(100000,999999);
//       #session保存验证码和手机号
//       $redisDate['bdCode'] = $randCode;
//       $redisDate['bdPhone'] = $phone;
//       Cache::set($phone,$redisDate,3600);
//       $param = array(
//            'mobile'    => $phone,
//            'tpl_id'    => (int)env('MESSAGE_ID'),
//            'tpl_value' => '#code#='.$randCode,
//            'key'       => env('MESSAGE_KEY'),
//            'dtype'     => 'json'
//       );
//       $api_url = env('MESSAGE_API');
//       $client = new Client();
//       try {
//           $response = $client->request('POST', $api_url,
//           ['headers' => ['Content-type' =>'application/json'],
//               'query'=> $param]);
//           $code = $response->getStatusCode();
//           $res = json_decode($response->getBody()->getContents());
//       } catch (\Exception $e) {
//           Log::error($e);
//            return false;
//       }
//       #存入记录
//       Db::table('sms')->insert([
//           'mobile'      => $phone,
//           'type'        => 1,
//           'status'      => $code == "200"? 1 : 0,
//           'content'     => '#code#='.$randCode,
//           'send_time'   => time(),
//           'sms_ret_msg' => $res->error_code == "0"?"success":"fail"
//       ]);
//       if($code == "200"&&$res->error_code == "0"){
//           return true;
//       }
//       Log::info("找回密码，手机号(".$phone.")短信发送失败");
//       return false;
//   }
   #websocket推送消息
    public function send(){
        $param = ['s_id'=>1, 'info'=>'info'];
        $param['token'] = '###';
        event(new BlogView($param));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:9502");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        //设置post数据
        $post_data = $param;
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_exec($ch);
        curl_close($ch);
    }
    #测试通知
    public function message(){
        $user =User::find(2);
        $user->notify(new InvoicePaid(['id'=>1]));
    }
    //只查询未读，使用unreadNotifications，下面是所有消息
    public function findMessage(){
        $user =User::find(2);
        foreach ($user->notifications as $notification) {
            echo \GuzzleHttp\json_encode($notification->data);
        }
    }
    //标记未已读
    public function read(){
        $user =User::find(1);
        //全部标记未已读
        $user->unreadNotifications->markAsRead();
        //指定的标记未已读
        DB::table('notifications')->where('id','')->update();
    }


}