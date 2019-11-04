<?php
/**
 * Created by PhpStorm.
 * User: hewei
 * Date: 2019/4/23
 * Time: 10:37 AM
 */

namespace App\Service;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
class Email
{

    #发送邮件方法找回密码
    public static function sendMail($email,$token,$sub){
        try {
            Mail::send("admin.public.linkBackPass",["token"=>route('recoverpass',
                ["token"=>$token,"type"=>0],"false")],
                function ($message)use($email,$sub){
                    $message->subject($sub);
                    $message->to($email);
                });
            return true;
        }catch (\Exception $e) {
            Log::error($e);
            return false;
        }
    }
    #发送邮件绑定邮箱
    public static function bdEmail($email,$sub){
        $code = rand(100000, 999999);
        try {
            Mail::send("admin.public.bdEmail",["token"=>route('recoverpass',
                ["code"=>$code],"false")],
                function ($message)use($email,$sub){
                    $message->subject($sub);
                    $message->to($email);
                });
            cache()->set('bdEmail:'. $email, sha1($code), 5);
            return true;
        }catch (\Exception $e) {
            Log::error($e);
            return false;
        }
    }
    #验证邮箱绑定
    public static function checkEmail($email,$code){
        $key      = 'bdEmail:' . $email;
        $email_code = cache()->get($key);
        if (!$email_code) {
            return '请先发送验证邮件';
        }
        if ($email_code != sha1($code)) {
            return '邮箱验证码错误';
        }
        cache()->delete($key);
        return '';

    }
}