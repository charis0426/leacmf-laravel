<?php

namespace App\Http\Controllers\Admin;

use App\Library\Help;
use App\Library\Y;
use App\Model\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     * //查询备份数据列表
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->post();
            Log::debug($post);
            //验证参数是否合法
            $validator = Validator::make($post, [
                'page_size' => 'required|integer',
                'page' => 'required|integer',
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }

            //查询数据
            $data = Data::orderBy('id', 'DESC');
            //判断是否有开始时间
            if ($request->has('start_time') && !empty($post['start_time'])){
                $data->where('created_at', '>=', $post['start_time']);
            }
            //判断是否有结束时间
            if ($request->has('end_time') && !empty($post['end_time'])){
                $data->where('created_at', '<=', $post['end_time']);
            }

            //获取分页
            $offset = Help::offset($post['page_size'], $post['page']);

            //查询数据
            try {
                $count = $data->count();
                $res = $data->offset($offset)
                    ->limit($post['page_size'])->get();
            }catch (\Exception $e){
                Log::error($e);
                return Y::error("查询异常");
            }
            //组装数据
            $record = ['data'=>$res,'current_page'=>$post['page'],
                'page_size'=>$post['page_size'], 'count'=>$count];
            Log::debug($record);
            //print_r($data->toSql());exit();
            return Y::success('查询成功', $record);
        }else{
            return view('admin.data.index_list');
        }
    }

    //数据备份
    public function backup(Request $request)
    {
        $post = $request->post();
        Log::debug($post);
        //验证参数是否合法
        $validator = Validator::make($post, [
            'type' => 'required',
        ]);
        if ($validator->fails()) {
            Log::error($validator->errors());
            return Y::error($validator->errors());
        }
        //分割字符串
        $type = explode(',', $post['type']);
        //获取当前时间
        $time = date('Ymd-His');
        //判断是否备份数据库
        if(in_array(1, $type)){
            //调用Artisan方法备份数据库
           $msg = $this->dataBackup(1, $time);
        }
        //判断是否备份程序
        if(in_array(2, $type)){
            //调用Artisan方法备份项目
            $msg = $this->dataBackup(2, $time);
        }
        if ($msg == 0) {
            return Y::success('备份成功');
        }else{
            return Y::error('备份失败');
        }

    }

    private function dataBackup($type, $time)
    {
        //备份数据
        if ($type == 1) {
            //组装文件名
            $title = 'db_' . $time . '.sql';
            $file = env('APP_BACKUP_PATH') . DIRECTORY_SEPARATOR . $title;
            $exec_command = 'mysqldump --host='.env('DB_HOST').' --user='.env('DB_USERNAME').' --password='.env('DB_PASSWORD').' '.env('DB_DATABASE').' > '. $file .'';
        }elseif ($type == 2){
            //组装文件名
            $title = 'file_' . $time . '.zip';
            $file = env('APP_BACKUP_PATH') . DIRECTORY_SEPARATOR . $title;
            $exec_command = 'zip -r '.$file.' '.base_path().'';
        }else{
            return 1;
        }
        exec($exec_command, $output, $status);
        if ($status != 0){
            return 1;
        }
        $data['description'] = '';
        $data['title'] = $title;
        $data['path'] = $file;
        $data['type'] = $type;
        //数据写入
        try {
            Data::create($data);
            $msg = 0;
        } catch (\Exception $e) {
            Log::error($e);
            $msg = 1;
        }
        return $msg;
    }

    //数据恢复
    public function recovery($id)
    {
        //查询记录
        $post = Data::find($id);
        //print_r($post);
        Log::debug($post);
        if(!$post){
            Log::error('数据不存在');
            return Y::error('数据不存在');
        }
        switch ($post['type'])
        {
            //还原数据库
            case 1:
                $file = $post['path'];
                if(!is_file($file)){
                    Log::error($file . '文件不存在');
                    return Y::error('文件不存在');
                }
                $execute_command = 'mysql --host='.env('DB_HOST').' --user='.env('DB_USERNAME').' --password='.env('DB_PASSWORD').' '.env('DB_DATABASE').' < '. $file .'';
                exec($execute_command, $output, $status);
                if ($status != 0){
                    Log::error($output);
                    return Y::error("数据库导入失败");
                }else{
                    Log::debug('数据库导入成功');
                    return Y::success('数据库导入成功');
                }
                break;
            //还原程序
            case 2:
                $zip = new \ZipArchive();
                //解压文件
                if ($zip->open($post['path'])){
                    $zip->extractTo(env('APP_CACHE_PATH'));
                    $zip->close();
                }else{
                    Log::error($post['path'] . '文件解压失败');
                    return Y::error('文件解压失败');
                }
                //项目路径
                $path = base_path();
                //分割路径及名称
                $n_path = substr($path, 0, strrpos($path,"/"));
                $file = env('APP_CACHE_PATH') . $path;
                $remove_command = 'rm -rf '.env('APP_CACHE_PATH').DIRECTORY_SEPARATOR.'* 2>&1';
                $mv_old_path = 'mv '.$path.' '.$path.'.bak 2>&1';
                exec($mv_old_path, $output, $status);
                if ($status !=0){
                    exec($remove_command);
                    Log::error($output);
                    return Y::error("项目还原失败");
                }
                $mv_new_path = 'mv '.$file.' '.$n_path.' 2>&1';
                exec($mv_new_path, $out, $state);
                if ($state ==0){
                    $remove_bak = 'rm -rf '.$path.'.bak 2>&1';
                    exec($remove_bak);
                    exec($remove_command);
                    Log::debug('项目还原成功');
                    return Y::success('项目还原成功');
                }else{
                    exec($remove_command);
                    Log::error($out);
                    return Y::error("项目还原失败");
                }
                break;
            default:
                Log::error('数据类型错误');
                return Y::error('数据类型错误');
        }
    }

    public function recoveryImg(Request $request)
    {
        $post = $request->post();
        Log::debug($post);
        //验证参数是否合法
        $validator = Validator::make($post, [
            'time' => 'required|date_format:"Y-m-d"',
        ]);
        if ($validator->fails()) {
            Log::error($validator->errors());
            return Y::error($validator->errors());
        }
        //组装图片存储目录
        $imgPath = env('APP_IMG_PATH'). DIRECTORY_SEPARATOR .$post['time'];
        //组装图片备份目录
        $backupPath = env('APP_IMG_BACKUP_PATH') . DIRECTORY_SEPARATOR . $post['time'];
        //判断备份目录是否存在
        if (!is_dir($backupPath)){
            Log::error('目录不存在');
            return Y::error('目录不存在');
        }
        //拷贝命令
        $command = 'cp -R ' . $backupPath . ' ' . $imgPath . ' 2>&1';
        if (!is_dir($imgPath)){
            exec($command, $output, $status);
            if ($status != 0){
                Log::error($output);
                return Y::error("图片还原失败");
            }
        }else{
            //先备份之前目录
            $mv_old_path = 'mv '.$imgPath.' '.$imgPath.'.bak 2>&1';
            exec($mv_old_path, $output, $status);
            if ($status != 0){
                Log::error($output);
                return Y::error("图片还原失败");
            }
            //执行拷贝
            exec($command, $out, $state);
            if ($state ==0){
                $remove_bak = 'rm -rf '.$imgPath.'.bak 2>&1';
                exec($remove_bak);
                Log::debug('图片还原成功');
            }else{
                Log::error($out);
                return Y::error("图片还原失败");
            }

        }
        return Y::success('图片还原成功');
    }

    //查看存储空间
    public function space()
    {
        //获取需要查看存储位置

        //获取存储位置已占用多少空间Process
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * 删除某个时间之前的数据
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $post = $request->post();
        Log::debug($post);
        //验证参数是否合法
        $validator = Validator::make($post, [
            'time' => 'required|date_format:"Y-m-d H:i:s"',
        ]);
        if ($validator->fails()) {
            Log::error($validator->errors());
            return Y::error($validator->errors());
        }
        //获取存储位置

        //如果是备份文件查询到备份记录并删除

        //删除时间之前的文件Process
    }
}
