<?php
/**
 * Created by PhpStorm.
 * User: lea
 * Date: 2018/1/30
 * Time: 14:34
 */

namespace App\Service;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class Sms
{

    #发送短信验证码
    public static function sendCode($mobile, $type = 'login')
    {
        if (app()->environment() == 'production') {
            //判断次数,5分钟内次数
            $count = DB::table('sms')->where('mobile', $mobile)->where('send_time', 'gt', time() - 300)->count();
            if ($count >= 3) {
                return '您发送短信太频繁，请稍后再试';
            }
            $count = Db::table('sms')->where('mobile', $mobile)->where('send_time', 'gt', time() - 24 * 60 * 60)->count();
            if ($count >= 10) {
                return '您今天发送短信太频繁，请以后再试';
            }

            $code = rand(100000, 999999);
        } else {
            $code = 123456;
        }
        $ret     = app()->environment() !== 'production' ? true : self::send($mobile,$code);

        Db::table('sms')->insert([
            'mobile'      => $mobile,
            'type'        => $type,
            'status'      => $ret === true ? 1 : 0,
            'content'     => "验证码发送:".$code,
            'send_time'   => time(),
            'sms_ret_msg' => strval($ret)== true ?"success":"fail"
        ]);
        cache()->set('sms:' . $type . ':' . $mobile, sha1($code), config('param.sms_rc_pass.TTL'));
        return $ret;
    }

    #验证短信验证码是否正确
    public static function check($mobile, $type, $code)
    {
        $key      = 'sms:' . $type . ':' . $mobile;
        $sms_code = cache()->get($key);
        if (!$sms_code) {
            return '请先发送短信验证码';
        }
        if ($sms_code != sha1($code)) {
            return '验证码错误';
        }
        cache()->delete($key);
        return '';
    }


    public static function send($mobile,$randCode)
    {
        #session保存验证码和手机号
        $param = array(
            'mobile'    => $mobile,
            'tpl_id'    => (int)config('param.sms_rc_pass.MESSAGE_ID'),
            'tpl_value' => '#code#='.$randCode,
            'key'       => config('param.sms_rc_pass.MESSAGE_KEY'),
            'dtype'     => 'json'
        );
        $api_url = config('param.sms_rc_pass.MESSAGE_API');
        $client = new Client();
        try {
            $response = $client->request('POST', $api_url,
                ['headers' => ['Content-type' =>'application/json'],
                    'query'=> $param]);
            $code = $response->getStatusCode();
            $res = json_decode($response->getBody()->getContents());
        } catch (\Exception $e) {
            Log::error($e);
            return false;
        }
        if($code == "200"&&$res->error_code == "0"){
            return true;
        }
        Log::info("找回密码，手机号(".$mobile.")短信发送失败");
        return false;

    }

}