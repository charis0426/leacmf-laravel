<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupImg extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup-img';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //获取前一天时间
        $time = date('Y-m-d', time()-(24*60*60));
        //组装图片存储目录
        $imgPath = env('APP_IMG_PATH'). DIRECTORY_SEPARATOR .$time;
        //组装图片备份目录
        $backupPath = env('APP_IMG_BACKUP_PATH') . DIRECTORY_SEPARATOR . $time;
        $command = 'cp -R ' . $imgPath . ' ' . $backupPath;
        //执行复制
        exec($command);
        //print_r($command);

    }


}


