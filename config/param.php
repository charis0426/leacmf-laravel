<?php
/**
 * Created by PhpStorm.
 * User: hewei
 * Date: 2019/4/30
 * Time: 14:35
 */

return [
    #短信服务api配置
    'sms_rc_pass'=>[
        'MESSAGE_API'=>'http://v.juhe.cn/sms/send',
        'MESSAGE_ID' =>'149105',
        'MESSAGE_KEY'=>'5eac1ebd7d177a4b21a58d4c613e0d29',
        'JWT_SECRET' =>'2J2arRQXeLngUCg2j5u74tGcRlBEDUkS',
        'TTL'        =>'5'
    ],
    #获取socket令牌api(golang控制器)
    'get_st_api'=>'http://192.168.1.53:8002/login?k=',
    #socket节点连接地址
    'socket_adr'=>'ws://192.168.1.53:8002/node/ws?token=',
    #golang平台服务地址
    'node_adr'=>'http://192.168.1.53:8000/',
    #视频回看前后时间区间间隔
    'playback_time'=>'5',
    #人工巡检视频轮询时间间隔(秒)
    'poll_time' =>'30',
    #海康视频插件参数配置
    'hk_video_config'=>[
        'snapDir'       => 'D:\\SnapDir',
        'videoDir'      => 'D:\\VideoDir',
        'layout'        => '1x1',
        'btIds'         => '',
        'showToolbar'   => '1',
        'showSmart'     => '1',
        'recordLocation'=> '0',//录像存储位置:0-中心存储 1-设备存储
        'transMode'     => 1,//传输协议:0-UDP 1- TCP
        'gpuMode'       => 0,//是否启用 GPU 硬解:0-不启用 1-启用
        'wndId'         => -1,//播放窗口序号0:空闲窗口播放，-1选中窗口播放 >1指定窗口
        'enableHTTPS'   => 1,//是否启用 HTTPS 协议 1:是 0:否
        'encryptedFields'=>'secret,snapDir,videoDir,layout',//初始化加密字段secret必填
        'encryptedFieldsPLay'=>'appkey,secret,ip',//回看加密字段,secret必填
        'privilege'     => 50,//用户的权限码1-100
        'streamMode'    => 0,//主子码流标识:0-主码流 1-子码流
    ],
    #人工巡检回看当前时间间隔(秒)
    'manual_playback_time'=>'600',
    'pic_path'=>'/data/pic/',
];

