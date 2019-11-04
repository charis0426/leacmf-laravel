<?php

namespace App\Http\Controllers\admin;

use App\Library\Help;
use App\Library\Y;
use App\Model\Department;
use App\Model\PTransportation;
use App\Model\Transportation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class PTransportationController extends Controller
{
    /**
     * Display a listing of the resource.
     * 查看重点转运中心列表
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
            //获取当前用户部门id
            $department_id = Auth::guard('admin')->user()->group_id;
            //$department_id = 1;
            //获取分页
            $offset = Help::offset($post['page_size'], $post['page']);
            //查询数据
            $data = PTransportation::where('point_transportations.department_id', $department_id);
            if ($request->has('name') && !empty($post['name'])){
                $data = $data->where('supervision_transportations.name', 'LIKE', '%'.$post['name'].'%');
            }
            $data->leftJoin('supervision_transportations', 'supervision_transportations.id',
                '=', 'point_transportations.t_id');
            $data->leftJoin('supervision_companys', 'supervision_companys.id',
                '=', 'supervision_transportations.pid');
            $data->select('supervision_transportations.*', 'point_transportations.*',
                'supervision_companys.name AS cname');
            $data->orderBy('point_transportations.id', 'DESC');
            //查询数据
            try {
                $res = $data->offset($offset)
                    ->limit($post['page_size'])->get();
                $count = $data->count();
            }catch (\Exception $e){
                Log::error($e);
                return Y::error("查询异常");
            }
            //print_r($res);
            $record = ['data'=>$res,'current_page'=>$post['page'],
                'page_size'=>$post['page_size'], 'count'=>$count];
            //print_r($record);
            Log::debug($record);
            echo(Y::success('查询成功', $record));
        }else{
            return view('admin.point.transportation.index_list');
        }
    }

    /**
     * Show the form for creating a new resource.
     * //添加重点转运中心
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            //获取当前用户部门id
            $department_id = Auth::guard('admin')->user()->group_id;
            //$department_id = 1;
            $post = $request->post();
            Log::debug($post);
            //验证参数是否合法
            $validator = Validator::make($post, [
                't_id' => 'exists:supervision_transportations,id',
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            $post['department_id'] = $department_id;
            //数据写入
            try {
                PTransportation::create($post);
            } catch (\Exception $e) {
                Log::error($e);
                return Y::error('添加失败');
            }
            Log::info('添加重点转运中心"'. $post['t_id'] .'"' . '成功');
            return Y::success('添加成功');
        }else{
            $record = Transportation::where('status', 0)->get();
            return view('admin.point.transportation.add', [
                'record'    => $record,
            ]);
        }
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
     * 查看重点转运中心信息
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //查询数据
        $data = PTransportation::where('point_transportations.id', $id);
        $data->Leftjoin('supervision_transportations', 'supervision_transportations.id',
            '=', 'point_transportations.t_id');
        $data->leftJoin('supervision_companys', 'supervision_companys.id',
            '=', 'supervision_transportations.pid');
        $data->select('supervision_transportations.*', 'point_transportations.*',
        'supervision_companys.name AS cname');
        //查询数据
        try {
            $record = $data->first();
        }catch (\Exception $e){
            Log::error($e);
            return Y::error("查询异常");
        }
        //$record = PTransportation::getTransportation($id);
        //print_r($record);exit();
        Log::debug($record);
        //返回模板和信息
        return view('admin.point.transportation.show', [
            'info'     => $record,
        ]);
    }

    //共享转运中心
    public function share(Request $request)
    {
        $post = $request->post();
        Log::debug($post);
        //验证参数是否合法
        $validator = Validator::make($post, [
            'id' => 'exists:point_transportations,id',
            'department_id' => 'exists:departments,id',
        ]);
        if ($validator->fails()) {
            Log::error($validator->errors());
            return Y::error($validator->errors());
        }
        //查询重点企业内容
        $record = PTransportation::find($post['id']);
        $data['t_id'] = $record->t_id;
        $data['department_id'] = $post['department_id'];
        //判断数据是否存在
        $res = PTransportation::where(['t_id'=>$data['t_id'], 'department_id'=>$data['department_id']])->get();
        //print_r($res);
        if (!$res->isEmpty()){
            Log::error('重点转运中心已经存在');
            return Y::error('重点转运中心已经存在');
        }
        //数据写入
        try {
            PTransportation::create($data);
        } catch (\Exception $e) {
            Log::error($e);
            return Y::error('共享失败');
        }
        Log::info('共享重点转运中心"'. $post['id'] .'"' . '成功');
        return Y::success('共享成功');
    }

    //查看重点转运中心下设备列表
    public function device($id)
    {
        //查询数据
        $record = Transportation::find($id)->device()->where('type', 0)->get(['id', 'name', 'cameraid']);
        return view('admin.point.transportation.device_list', [
            'info'     => $record,
        ]);
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
     * 删除重点转运中心
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //数据删除
        try {
            PTransportation::destroy($id);
            Log::info('删除成功');
            return Y::success('删除成功');
        } catch (\Exception $e) {
            Log::error($e);
            return Y::error('删除失败');
        }
    }
}
