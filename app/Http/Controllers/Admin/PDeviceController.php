<?php

namespace App\Http\Controllers\admin;

use App\Library\Help;
use App\Library\Y;
use App\Model\Brand;
use App\Model\Company;
use App\Model\Department;
use App\Model\Device;
use App\Model\Dot;
use App\Model\PCompany;
use App\Model\PDevice;
use App\Model\PObject;
use App\Model\Transportation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class PDeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     * 显示设备列表
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->post();
            //验证参数是否合法
            $validator = Validator::make($post, [
                'page_size' => 'required|integer',
                'page' => 'required|integer',
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            //获取当前用户部门id
            $group_id = Auth::guard('admin')->user()->group_id;
            //$group_id = 5;
            Log::debug($post);

            //获取分页
            $offset = Help::offset($post['page_size'], $post['page']);
            //查询数据
            $data = PDevice::orderBy('id', 'DESC');
            $data->where('user_id', $group_id);
            // 左连接所属公司
            $data->leftJoin('point_objects', function ($query) {
                $query->on('point_objects.id', '=', 'point_devices.pid');
            });
            //查询字段
            $data->select('point_devices.*', 'point_objects.name AS pname');
            //查询数据
            try {
                $count = $data->count();
                $res = $data->offset($offset)
                    ->limit($post['page_size'])->get();
            }catch (\Exception $e){
                Log::error($e);
                return Y::error("查询异常");
            }
            $record = ['data'=>$res,'current_page'=>$post['page'],
                'page_size'=>$post['page_size'], 'count'=>$count];
            Log::info($record);
            return Y::success('查询成功', $record);
        }else{
            return view('admin.company.index_list');
        }
    }

    /**
     * Show the form for creating a new resource.
     * 添加重点设备
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            //获取当前用户部门id
            $group_id = Auth::guard('admin')->user()->group_id;
            //$group_id = 5;
            $post = $request->post();
            Log::debug($post);
            //验证参数是否合法
            $validator = Validator::make($post,
                [
                    'id' => 'required:integer',
                    'name' => 'required:integer',
                    'cameraid' => 'string',
                ],
                [],
                ['id' => '重点对象id', 'name' => '设备名称', 'cameraid' => '设备编号']
            );
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            $data['pid'] = $post['id'];
            $data['name'] = $post['name'];
            $data['cameraid'] = $post['cameraid'];
            $data['user_id'] = $group_id;
            //print_r($data);
            if(PDevice::where('user_id', $group_id)->where('cameraid', $post['cameraid'])->count()){
                return Y::error('设备已在列表');
            }
            //数据写入
            try {
                PDevice::create($data);
            } catch (\Exception $e) {
                Log::error($e);
                return Y::error('添加失败');
            }
            Log::info('添加设备到列表成功"'. $data['name'] .'"' . '成功');
            return Y::success('添加成功');
        }else{
            return view('admin.point.add');
        }
    }


    /**
     * Remove the specified resource from storage.
     * 删除重点对象
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //数据删除
        try {
            PDevice::destroy($id);
            Log::info('删除成功');
            return Y::success('删除成功');
        } catch (\Exception $e) {
            Log::error($e);
            return Y::error('删除失败');
        }
    }
    /*
     * Batch remove the specified resource from storage.
     * 批量删除重点对象
     * @param  array  $ids
     * @return \Illuminate\Http\Response
     */
    public function batchDestroy(Request $request)
    {
        #判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->post();
            #验证参数是否合法
            $validator = Validator::make($post, [
                'ids' => 'required|array'
            ],  [],  [
                'ids' => '参数'
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            #判断数据长度是否为0
            if(count($post['ids']) == 0){
                return Y::error("删除对象为空");
            }
            #遍历删除数据，返回成功删除数
            $count = 0;
            foreach ($post['ids'] as $id){
                try {
                    PDevice::destroy($id);
                    $count ++;
                } catch (\Exception $e) {
                    Log::error($e);
                }
            }
            return Y::success("删除成功",['count'=>$count]);
        }
        return Y::error("非法请求类型");
    }

}
