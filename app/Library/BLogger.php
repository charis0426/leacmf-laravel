<?php
/**
 * Created by PhpStorm.
 * User: lea
 * Date: 2017/12/13
 * Time: 下午3:28
 */

namespace App\Library;

use Log;


class BLogger
{
    // 调试
    const LOG_DEBUG = 'debug';
    // 信息
    const LOG_INFO = 'info';
    // 警告
    const LOG_WARNING = 'warning';
    // 错误
    const LOG_ERROR = 'error';

    private static $loggers = array();

    // 获取一个实例
    public static function writeLogger($type = self::LOG_ERROR, $info = '')
    {
        Log::useDailyFiles(storage_path().'/log.log', 30);
        Log::info('info');
    }

}