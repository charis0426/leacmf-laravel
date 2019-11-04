<?php

namespace App\Http\Controllers\Admin;

use App\Library\Y;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    //本地上传
    public function upload(Request $request, $type)
    {
        $validator = Validator::make($request->all(), [
            'face'     => 'mimes:jpeg,bmp,png,gif|max:240',  //头像
            'trademark'=> 'mimes:jpeg,bmp,png,gif|max:240',  //商标
            'licenses' => 'mimes:jpeg,bmp,png,gif|max:720',  //营业执照
            'cover'    => 'mimes:jpeg,bmp,png,gif|size:500', //大图
            'video'    => 'mimes:mp4,avi|size:40960',
            'audio'    => 'mimes:mp3|size:4096',
            'document' => 'mimes:doc,docx,xls,xlsx|size:2048', //文档
            'attach'   => 'mimes:zip|size:2048000', //附件
        ]);
        if ($validator->fails()) {
            Log::error($validator->errors());
            return Y::error($validator->errors());
        }
        if (!$request->hasFile($type)) {
            Log::error('上传的文件不能为空');
            return Y::error('上传的文件不能为空');
        }
        $file = $request->{$type};
        $path = $file->store($type);

        $path = env('APP_UPLOAD_PATH') . '/' . $path;
        Log::info('文件上传成功');
        return Y::success('上传成功', [
            'path' => $path,
            'url'  => asset($path)
        ]);
    }

    /*
     *断点续传 状态码200成功，500错误，501写入失败，502写入文件和原文件大小不一致
     * @param Request $request
     * @return json
    */
    public function uploadContinueFile(Request $request){
        $post = $request->all();
        $validator = Validator::make($post, [
            'theFile'     => 'required', //文件名
            'totalSize'   => 'required|int',
            'fileName'     => 'required|string',
            'start'        => 'required|int',
            'end'          => 'required|int',
            'isLastChunk'  => 'required|int',
            'isFirstUpload'=> 'required|int'
         ]);
        if ($validator->fails()) {
            Log::error($validator->errors());
            return Y::error($validator->errors());
        }
        $fileName = iconv('utf-8','gbk',$request->{'fileName'});
        $totalSize = $request->{'totalSize'};
        $isLastChunk = $request->{'isLastChunk'};
        $isFirstUpload = $request->{'isFirstUpload'};
        if ($_FILES['theFile']['error'] > 0) {
            Log::info("文件断点续传文件出现错误");
            $status = 500;
        } else {
            #如果第一次上传的时候，该文件已经存在，则删除文件重新上传
            if ($isFirstUpload == '1' && file_exists(env('NODE_UPGRADE_PATH') . '/' . $fileName) && filesize(env('NODE_UPGRADE_PATH') . '/' . $fileName) >= $totalSize) {
                unlink(env('NODE_UPGRADE_PATH') . '/'. $fileName);
            }
            #否则继续追加文件数据
            if (!file_put_contents(env('NODE_UPGRADE_PATH') . '/' . $fileName, file_get_contents($_FILES['theFile']['tmp_name']), FILE_APPEND)) {
                Log::info("文件断点续传文件写入失败");
                $status = 501;
            } else {
                #在上传的最后片段时，检测文件是否完整（大小是否一致）
                if ($isLastChunk === '1') {
                    if (filesize(env('NODE_UPGRADE_PATH') . '/' . $fileName) == $totalSize) {
                        $status = 200;
                    } else {
                        Log::info("文件断点续传文件总大小不一致");
                        $status = 502;
                    }
                } else {
                    $status = 200;
                }
            }
        }
        echo json_encode(array(
            'status' => $status,
            'totalSize' => filesize(env('NODE_UPGRADE_PATH') . '/' . $fileName),
            'isLastChunk' => $isLastChunk
        ));

    }
}
