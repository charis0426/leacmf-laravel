<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'webauth'], function () {
    Route::get('/', 'Web\IndexController@index');
    Route::get('/ievent', 'Web\IndexController@ievent');
    Route::get('/aevent', 'Web\IndexController@aevent');
    Route::post('/api/statistics/get', 'Web\IndexController@statistics');
    Route::post('/api/eventrecord/find', 'Web\IndexController@eventrecord');
    Route::post('/index/dvlist', 'Web\IndexController@device');
    Route::post('/ievent/pdvlist', 'Web\IndexController@show');

});

#找回密码按钮链接
Route::any('/backpass', 'Admin\PublicController@checkCaptcha')->name('backpass');
#找回密码链接
Route::any('/recoverpass/token/{token}/type/{type}', 'Admin\PublicController@recoverPass')->name('recoverpass');
/*
 * 发送短信
 * */
Route::any('/public/sendsms', 'Admin\PublicController@sendSms')->name('sendsms');
#websocket推送测试
Route::any('/public/send', 'Admin\PublicController@send')->name('sendsocket');
#测试消息通知
Route::any('/message', 'Admin\PublicController@message')->name('message');
#查看自己的消息
Route::any('/findmessage', 'Admin\PublicController@findMessage')->name('findmessage');
#验证找回密码随机验证码和手机/邮箱是否正确
Route::any('/checkidentity/token/{token}', 'Admin\PublicController@ckRvPass')->name('checkidentity');
#邮箱发送成功页面，短信发送成功和继续发送短信
Route::any('/backinfo/token/{token}', 'Admin\PublicController@backPssInfo')->name('backinfo');
#验证短信验证码是否正确
Route::any('/checkSmsCode', 'Admin\PublicController@checkCode')->name('checksmscode');
#过期模版路由
Route::get('/expiredInfo', 'Admin\PublicController@expiredInfo')->name('expiredinfo');
Route::any('/upload', 'Admin\FileController@uploadContinueFile')->name('upload-continue');
Route::get("fileTest", function () {
    return view('admin.public.fileTest');
});
Route::get("apitest", function () {
    return view('admin.index.new_index');
});