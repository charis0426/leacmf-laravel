<?php

namespace App\Http\Controllers\admin;

use App\Library\Help;
use App\Library\Y;
use App\Model\PBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class PBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     * 查看重点品牌列表
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
            //获取分页
            $offset = Help::offset($post['page_size'], $post['page']);
            //查询数据
            $data = PBrand::orderBy('point_brands.id', 'DESC');
            if ($request->has('name') && !empty($post['name'])){
                $data = $data->where('supervision_brands.name', 'LIKE', '%'.$post['name'].'%');
            }
            if ($request->has('company') && !empty($post['company'])){
                $data = $data->where('supervision_brands.company', 'LIKE', '%'.$post['company'].'%');
            }
            $data->leftJoin('supervision_brands', 'supervision_brands.id',
                '=', 'point_brands.b_id');
            $data->select('supervision_brands.*', 'point_brands.*');
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
     * 添加重点品牌
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->post();
            Log::debug($post);
            //验证参数是否合法
            $validator = Validator::make($post, [
                'b_id' => 'exists:supervision_brands,id',
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            //数据写入
            try {
                PBrand::create($post);
            } catch (\Exception $e) {
                Log::error($e);
                return Y::error('添加失败');
            }
            Log::info('添加重点品牌"'. $post['b_id'] .'"' . '成功');
            return Y::success('添加成功');
        }else{
            return view('admin.point.brand.add');
        }
    }

    /**
     * Display the specified resource.
     * 查看品牌基本信息
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //查询数据
        $data = PBrand::where('point_brands.id', $id);
        $data->Leftjoin('supervision_brands', 'supervision_brands.id',
            '=', 'point_brands.b_id');
        $data->select('supervision_brands.*', 'point_brands.*');
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
        return view('admin.point.brand.show', [
            'info'     => $record,
        ]);
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
            PBrand::destroy($id);
            Log::info('删除成功');
            return Y::success('删除成功');
        } catch (\Exception $e) {
            Log::error($e);
            return Y::error('删除失败');
        }
    }
}
