<?php

namespace App\Http\Controllers\admin;

use App\Library\Help;
use App\Library\Y;
use App\Model\PDot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class LoopController extends Controller
{
    /**
     * Display a listing of the resource.
     * 查看重点网点列表
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
            //$department_id = 3;
            //获取分页
            $offset = Help::offset($post['page_size'], $post['page']);
            //查询数据
            $data = PDot::where('point_dots.department_id', $department_id);
            if ($request->has('name') && !empty($post['name'])){
                $data = $data->where('supervision_dots.name', 'LIKE', '%'.$post['name'].'%');
            }
            $data->leftJoin('supervision_dots', 'supervision_dots.id',
                '=', 'point_dots.d_id');
            $data->leftJoin('supervision_companys', 'supervision_companys.id',
                '=', 'supervision_dots.pid');
            $data->select('supervision_dots.*', 'point_dots.*',
                'supervision_companys.name AS cname');
            $data->orderBy('point_dots.id', 'DESC');
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
            Log::info($record);
            echo(Y::success('查询成功', $record));
        }else{
            return view('admin.point.transportation.index_list');
        }
    }

    /**
     * Show the form for creating a new resource.
     * 添加重点网点
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
                'd_id' => 'exists:supervision_dots,id',
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            $post['department_id'] = $department_id;
            //数据写入
            try {
                PDot::create($post);
            } catch (\Exception $e) {
                Log::error($e);
                return Y::error('添加失败');
            }
            Log::info('添加重点网点"'. $post['d_id'] .'"' . '成功');
            return Y::success('添加成功');
        }else{
            return view('admin.point.dot.add');
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
     * 查看网点基本信息
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //查询数据
        $data = PDot::where('point_dots.id', $id);
        $data->Leftjoin('supervision_dots', 'supervision_dots.id',
            '=', 'point_dots.d_id');
        $data->leftJoin('supervision_companys', 'supervision_companys.id',
            '=', 'supervision_dots.pid');
        $data->select('supervision_dots.*', 'point_dots.*',
            'supervision_companys.name AS cname');
        //查询数据
        try {
            $record = $data->first();
        }catch (\Exception $e){
            Log::error($e);
            return Y::error("查询异常");
        }
        //print_r($record);exit();
        Log::info($record);
        //返回模板和信息
        return view('admin.point.dot.show', [
            'info'     => $record,
        ]);
    }

    

    //查看重点网点下设备列表
    public function device($id)
    {
        //查询数据
        $record = PDot::find($id)->device()->where('type', 1)->get(['id', 'name', 'cameraid']);
        Log::info($record);
        return view('admin.point.dot.device_list', [
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //数据删除
        try {
            PDot::destroy($id);
            Log::info('删除成功');
            return Y::success('删除成功');
        } catch (\Exception $e) {
            Log::error($e);
            return Y::error('删除失败');
        }
    }
}
