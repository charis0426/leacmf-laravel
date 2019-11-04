<?php

namespace App\Http\Controllers\Admin;

use App\Model\Department;
use App\Model\StaticalAnalysisConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Y;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class StaticalAnalysisConfigController extends Controller
{
    /**
     * 统计分析配置
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function  index(Request $request){
        if($request->isMethod('post')){
            #验证数据合法性
            $post      = $request->post();
            $validator = Validator::make($post, [
                'id'              => 'int',
                'number'          => 'required|int',
                'type'            => 'required|string',
                'time'            => 'required|string'
            ],[],['id'    =>'参数',
                'number'  =>'并发数',
                'type'    =>'任务类型',
                'time'    =>'摄像机编号'
            ]);
            if ($validator->fails()) {
                return Y::error($validator->errors());
            }
            #组装时间区间
            $i = 0;
            $str = '';
            foreach ($post['time'] as $value){
                if($i == 0){
                    $str = $value;
                }else{
                    $str += ','+$value;
                }
                $i++;
            }
            $post['time'] = $str;
            #判断是新增还是修改
            if(isset($post['id'])&&$post['id']!=""){
                $statical_analysis = StaticalAnalysisConfig::find($post['id']);
                if($statical_analysis->update($post)){
                    return Y::success("保存成功");
                }
            }else{
                if(StaticalAnalysisConfig::create($post)){
                    return Y::success("保存成功");
                }
            }
            return Y::error("保存失败");
        }
        #查询当前管理员管理区域的配置信息，只有市级管理员有权限
        $department_id= Auth::guard('admin')->user()->group_id;
        $res  = $this->checkDepartment();
        if($res == 2){
            #市级
            $ret = StaticalAnalysisConfig::where('department_id',$department_id)->get(1);
            return view('',['list'=>$ret]);
        }else if($res == 1 ){
            #省级返回查看市级列表页面
            #查询省级下面的市级列表
            $department_ids = Department::where('pid',$department_id)->get()->map(function ($value){
                return $value->id;
            });
            $ret = StaticalAnalysisConfig::wherein('department_id',$department_ids)->get();
            return view('',['list'=>$ret]);
        }else{
            #未读取到组织机构
            return Y::error("Network Error");
        }

    }
}
