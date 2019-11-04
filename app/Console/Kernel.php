<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\StatisticalTask::class,
        Commands\BackupImg::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //备份数据库
        /*//组装文件名
        $title = 'db_' . date('Ymd-His') . '.sql';
        $file = env('APP_ACCORD_BACKUP_PATH') . DIRECTORY_SEPARATOR . $title;
        $exec_command = '/usr/bin/mysqldump --host='.env('DB_HOST').' --user='.env('DB_USERNAME').' --password='.env('DB_PASSWORD').' '.env('DB_DATABASE').' > '. $file .'';
        file_put_contents(env('APP_ACCORD_BACKUP_PATH').'/1.txt', $exec_command);
        $schedule->exec($exec_command)->everyMinute();*/

        $db_title = 'db_' . date('Ymd-His') . '.zip';
        $schedule->command('backup:run --filename='.$db_title.' --only-db')
            ->daily()->at('03:00');

        //备份文件
        //组装文件名
        $title = 'file_' . date('Ymd-His') . '.zip';
        $file = env('APP_ACCORD_BACKUP_PATH') . DIRECTORY_SEPARATOR . $title;
        $exec_command_file = 'zip -r '.$file.' '.base_path().'';
        $schedule->exec($exec_command_file)->daily()->at('03:00');

        /*
        $data_title = 'file_' . date('Ymd-His') . '.zip';
        $schedule->command('backup:run --filename='.$data_title.' --only-files')
            ->daily()->at('03:00');*/
        //删除过期备份
        $rm_command = 'find '.env('APP_ACCORD_BACKUP_PATH').' -type f -mtime +7 -exec rm -f {} \;';
        $schedule->exec($rm_command)->daily()->at('04:00');

        //删除过期日志
        $rm_logs = 'find '.env('APP_LOG_PATH').' -type f -mtime +'.env('APP_LOG_KEEP_DAY').' -exec rm -f {} \;';
        $schedule->exec($rm_logs)->daily()->at('04:00');

        //执行可视化定制报告
        $schedule->command('statistical-task')->daily()->at('00:01');

        //执行图片备份
        $schedule->command('backup-img')->daily()->at('01:00');

        //执行统计设备
        $schedule->command('statistical-device')->daily()->at('02:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
