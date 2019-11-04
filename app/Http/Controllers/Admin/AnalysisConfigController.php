<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AnalysisConfig;
use App\Library\Y;
use Illuminate\Support\Facades\Validator;
class AnalysisConfigController extends Controller
{
    /*
    *
    * 统计分析配置信息
    * @param Request $request
    * @return view or json
    */
    public function  index(Request $request){
        if ($request->isMethod('post')) {
            #验证数据合法性
            $post      = $request->post();
            Log::debug($post);
            $validator = Validator::make($post, [
                'id'              => 'required|int',
                'Models'          => 'required|string',
                'Frequency'       => 'required|int',
                'StartTime'       => 'required|string',
                'EndTime'         => 'required|string',
                'CamId'           => 'required|string',
                'Url'             => 'required|string'
            ],[],['Models'    =>'分析模型',
                  'Frequency' =>'分析频率',
                  'StartTime' =>'开始时间',
                  'EndTime'   =>'结束时间',
                  'CamId'     =>'摄像机编号',
                  'Url'       =>'摄像机rstp地址'
            ]);
            if ($validator->fails()) {
                return Y::error($validator->errors());
            }
            $res  = $this->request('POST','analysis/add',$post);
            if($res){
                return Y::success("配置成功",$res);
            }
            return Y::error("配置失败");
        }
    }

    /*
    *根据转运中心/网点查询设备
    * @param Request $request
    * @return view or json
    */
    public function queryDevice(Request $request){
        if($request->isMethod('post')){
            #验证数据合法性
            $post      = $request->post();
            Log::debug($post);
            $validator = Validator::make($post, [
                'id'              => 'required|int'
            ],[],['id'    =>'设备编号']);
            if ($validator->fails()) {
                return Y::error($validator->errors());
            }
            #查询配置信息返回模版
            $res = AnalysisConfig::where('id',$post['id'])->get(1);
            if($res->count()){
                return Y::success("查询成功",$res);
            }
            return Y::error("查询失败");
        }
        #返回智能分析配置首页
        $id   = $request->get('id');
        $type = $request->get('type');
        #判断该用户所属结构是否是市级
        if($this->checkDepartment() != 2){
            return Y::error("当前用户没有操作权限");
        }
        #区分是网点还是转运中心1网点,0转运中心
        $data['type'] = $type;
        $data['dt_id'] = $id;
        $data['department_id'] = Auth::guard('admin')->user()->group_id;
        $res = AnalysisConfig::where($data)->get();
        return view('admin.analysisConfig.index',["list"=>$res]);

    }
    /*
    * 根据设备id
    * @param Request $request
    * @return view or json
    */
    public function hls(Request $request){
        if($request->isMethod('post')){
            #验证数据合法性
            $post      = $request->post();
            Log::debug($post);
            $validator = Validator::make($post, [
                'deviceId'              => 'required|string'
            ],[],['deviceId'    =>'设备编号']);
            if ($validator->fails()) {
                return Y::error($validator->errors());
            }
            #通过设备id查询实时流地址
            $map['CameraIndexCode'] = $post['deviceId'];
            $map['Protocol'] = 'rtsp';
            $map['StreamType'] = '0';
            $res = $this->request($type="POST","previewurl/get",$map);
            if($res && $res->ErrCode == 0){
                return Y::success("查询成功",$res);
            }
            return Y::error("查询失败");
        }

    }
}
