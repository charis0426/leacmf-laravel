<?php
/**
 * Created by PhpStorm.
 * User: hewei
 * Date: 2019/10/21
 * Time: 10:29 AM
 */

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Library\Y;
use App\Model\PDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Model\Dot;
use App\Model\Transportation;
class IndexController extends Controller
{

    /*
     * 展示页面监管对象首页
     */
    public function index()
    {
        $id = Auth::guard('admin')->user()->group_id;
        return view('admin.index.new_index', ['id' => $id]);
    }

    /*
     * 展示页面智能分分析页面
     */
    public function aevent()
    {
        $id = Auth::guard('admin')->user()->group_id;
        return view('admin.index.aevent', ['id' => $id]);
    }

    /*
     * 展示页面智能分分析页面
     */
    public function ievent()
    {
        $id = Auth::guard('admin')->user()->group_id;
        return view('admin.index.play', ['id' => $id]);
    }

    /*
     * 获取页面静态统计数据
     * */
    public function statistics(Request $request)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->post();
            //验证参数是否合法
            $validator = Validator::make($post, [
                'DataType' => 'required|int',
                'Did' => 'required|int',
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            $post['DataType'] = (int)$post['DataType'];
            $post['Did'] = (int)$post['Did'];
            $res = $this->request('POST', 'statistics/get', $post);
            if ($res && $res->ErrCode == 0) {
                return Y::success('查询成功', $res->rsp);
            }
            return Y::error("查询失败");
        }
    }

    /*
     * 获取海康视频参数
     * */
    public function eventrecord(Request $request)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->post();
            //验证参数是否合法
            $validator = Validator::make($post, [
                'CameraIndexCode' => 'required',
                'StartTime' => 'required',
                'EventType' => 'required',
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            $post['CameraIndexCode'] = (string)$post['StartTime'];
            $post['StartTime'] = (string)$post['StartTime'];
            $post['EventType'] = (string)$post['EventType'];
            $res = $this->request('POST', 'eventrecord/find', $post);
            if ($res && $res->ErrCode == 0) {
                $data = [
                    'ErrCode' => $res->ErrCode,
                    'Rsp' => $res->Rsp,
                    'ErrMsg' => $res->ErrMsg,
                ];
                exit(json_encode($data));
            }
            return Y::error("查询失败");
        }
    }
    /*
     * 通过转运中心/网点获取设备列表
     */
    public function device(Request $request)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->post();
            //验证参数是否合法
            $validator = Validator::make($post, [
                'id' => 'required|int',
                'type' => 'required|int'
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            //查询数据
            $record=[];
            if($post['type'] == 1) {
                $record = Dot::find($post['id'])->device()->where('type', 1)
                    ->get(['id', 'name', 'cameraid'])->toarray();
            }else if($post['type'] ==0){
                $record = Transportation::find($post['id'])->device()->where('type', 0)
                    ->get(['id', 'name', 'cameraid'])->toarray();
            }
            Log::info($record);
            return Y::success('查询成功', $record);
        }
    }
    /*
     * 查询轮播对象设备列表
     */
    public function show(Request $request){
        //判断请求方式
        if ($request->isMethod('post')) {
            $record = PDevice::select('cameraid')->get();
            return Y::success('查询成功', $record);
        }
    }

}