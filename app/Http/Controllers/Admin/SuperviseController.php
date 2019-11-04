<?php

namespace App\Http\Controllers\Admin;

use App\Library\Help;
use App\Library\Y;
use App\Model\AnalysisModel;
use App\Model\AnalysisModelContent;
use App\Model\AnalysisTime;
use App\Model\Brand;
use App\Model\Company;
use App\Model\Department;
use App\Model\Device;
use App\Model\Dot;
use App\Model\Transportation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class SuperviseController extends Controller
{

    /**
     * Display a listing of the resource.
     * 显示智能分析模型列表
     * @return \Illuminate\Http\Response
     */
    public function analysisModel(Request $request)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            //获取当前用户部门id
            $department_id = Auth::guard('admin')->user()->group_id;
            $record = AnalysisModel::select('id', 'models', 'type', 'model_run_time')->get();
            foreach ($record as &$item) {
                $child = AnalysisModelContent::where('pid', $item->id)->where('department_id', $department_id)->first();
                $item->updated_at = $child['updated_at'];
            }
            Log::info($record);
            return Y::success('查询成功', $record);
        } else {
            return view('admin.supervise.index_list');
        }
    }

    /**
     * Display a listing of the resource.
     * 删除智能分析模型配置
     * @return \Illuminate\Http\Response
     */
    public function deleteModel($id)
    {
        if (AnalysisModelContent::destroy($id) > 0) {
            Log::info('关闭模型成功');
            return Y::success('关闭成功');
        }
        Log::error('关闭模型失败');
        return Y::error('关闭失败');
    }

    /**
     * Display a listing of the resource.
     * 修改智能分析模型配置
     * @return \Illuminate\Http\Response
     */
    public function updateModel(Request $request, $id)
    {
        //获取当前用户部门id
        $group_id = Auth::guard('admin')->user()->group_id;
        //$group_id = 35;
        //判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->post();
            //验证参数是否合法
            $validator = Validator::make($post, [
                'e_count' => 'required|integer',
                'e_hour' => 'required|numeric',
            ],
                [],
                ['e_count' => '次数', 'e_hour' => '时间']);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            $data['e_count'] = $post['e_count'];
            $data['e_hour'] = $post['e_hour'];
            //isset($post['area']) ? $data['area'] = $post['area'] : '';
            $data['area'] = isset($post['area']) ? $post['area'] : '';
            $model = AnalysisModelContent::where('pid', $id)->where('department_id', $group_id)->first();
            $params = [
                'DepartmentId' => (int)$group_id,
                'Count' => (int)$post['e_count'],
                'Hour' => (float)$post['e_hour']
            ];
            if ($model) {
                if ($model->update($data)) {
                    $params['EventType'] = (string)$model->pid;
                    $this->request('POST', 'filterpara/update', $params);
                    Log::info('修改模型"' . $model->name . '"' . '成功');
                    return Y::success('配置成功');
                }
                Log::error('修改模型"' . $model->name . '"' . '失败');
                return Y::success('配置失败');
                //print_r('aaa');
            } else {
                $data['pid'] = $id;
                $data['department_id'] = $group_id;
                $params['EventType'] = (string)$id;
                //数据写入
                try {
                    AnalysisModelContent::create($data);
                    $this->request('POST', 'filterpara/update', $params);
                    Log::info('修改模型成功');
                    return Y::success('配置成功');
                } catch (\Exception $e) {
                    Log::error($e);
                    return Y::error('配置失败');
                }
            }
        } else {
            $record = AnalysisModelContent::where('pid', $id)->where('department_id', $group_id)->first();
            $parent = AnalysisModel::select('id', 'models', 'type')->find($id);
            $record['id'] = $record['id'] ? $record['id'] : $parent->id;
            $record['models'] = $parent->models;
            $record['type'] = $parent->type;
            if (!$record) {
                $record = AnalysisModel::find($id);
            }
            return Y::success('查询成功', $record);
        }
    }

    /**
     * Display a listing of the resource.
     * 显示监管时间列表
     * @return \Illuminate\Http\Response
     */
    public function analysisTime(Request $request)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            //获取当前用户部门id
            $department_id = Auth::guard('admin')->user()->group_id;
            $record = AnalysisTime::where('department_id', $department_id)->get();
            Log::info($record);
            return Y::success('查询成功', $record);
        } else {
            return view('admin.supervise.index_list');
        }
    }

    /**
     * Show the form for creating a new resource.
     * 添加监管时间
     * @return \Illuminate\Http\Response
     */
    public function addTime(Request $request)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            //获取当前用户部门id
            $department_id = Auth::guard('admin')->user()->group_id;
            //$department_id = 1400;
            $post = $request->post();
            Log::debug($post);
            //验证参数是否合法
            $validator = Validator::make($post, [
                'start_time' => 'required',
                'end_time' => 'required',
                'type' => 'required|integer',
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            $post['department_id'] = $department_id;
            //数据写入
            try {
                AnalysisTime::create($post);
            } catch (\Exception $e) {
                Log::error($e);
                return Y::error('添加失败');
            }
            Log::info('添加监管成功');
            return Y::success('添加成功');
        } else {
            return view('admin.supervise.add');
        }
    }

    /**
     * Show the form for creating a new resource.
     * 同步工作时间
     * @return \Illuminate\Http\Response
     */
    public function syncTime(Request $request)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            //获取当前用户部门id
            $department_id = Auth::guard('admin')->user()->group_id;
            //$department_id = 1400;
            $post = $request->post();
            Log::debug($post);
            //验证参数是否合法
            $validator = Validator::make($post, [
                'type' => 'required|integer',
            ]);
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            $type = $post['type'];
            $times = AnalysisTime::where('department_id', $department_id)->where('type', $type)
                ->select('start_time', 'end_time')->get()->toArray();
            $data = array();
            foreach ($times as $k => $v) {
                $data[] = $v['start_time'] . ' ~ ' . $v['end_time'];
            }
            $str['work_time'] = implode($data, ',');
            //批量更新
            try {
                Dot::where('department_id', $department_id)->update($str);
            } catch (\Exception $e) {
                Log::error($e);
                return Y::error('同步失败');
            }
            return Y::success('同步成功');
        }

    }

    /**
     * Remove the specified resource from storage.
     * 删除监管时间
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (AnalysisTime::destroy($id) > 0) {
            Log::info('删除监管时间成功');
            return Y::success('删除成功');
        }
        Log::error('删除监管时间失败');
        return Y::error('删除失败');
    }

    /**
     * Show the form for creating a new resource.
     * 获取监管转运中心列表
     * @return \Illuminate\Http\Response
     */
    public function TransportationList(Request $request)
    {
        //获取当前用户部门id
        $group_id = Auth::guard('admin')->user()->group_id;
        //$department_id = 1;
        //查询数据
        $data = Transportation::orderBy('id', 'DESC');
        $data->where('department_id', $group_id);
        //查询数据
        try {
            $res = $data->get()->mapWithKeys(function ($item) {
                return [$item['id'] => $item['name']];
            });
            Log::info($res);
        }catch (\Exception $e){
            Log::error($e);
            return Y::error("查询异常");
        }
        return Y::success('查询成功', $res);
    }

    /**
     * Display a listing of the resource.
     * 显示人工巡检转运中心列表
     * @return \Illuminate\Http\Response
     */
    public function transportation(Request $request)
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
            //$group_id = 271;
            Log::debug($post);
            //获取分页
            $offset = Help::offset($post['page_size'], $post['page']);
            //查询数据
            $data = Transportation::orderBy('supervision_transportations.id', 'DESC');
            $data->where('supervision_transportations.department_id', $group_id);
            //判断是否有name
            /*if ($request->has('name') && !empty($post['name'])) {
                $data->where('supervision_transportations.name', 'LIKE', '%' . $post['name'] . '%');
            }*/
            if ($request->has('id') && !empty($post['id'])) {
                $data->where('supervision_transportations.id', $post['id'] );
            }
            //print_r($data->toSql());
            //exit();
            //查询数据
            try {
                //统计总数
                $count = $data->count();
                //左连接查询品牌
                /*$data->leftJoin('supervision_brands', function ($query) {
                    $query->whereRaw("find_in_set(supervision_brands.id, supervision_transportations.brand_ids)");
                });*/
                $data->leftJoin('supervision_companys', 'supervision_companys.id', '=', 'supervision_transportations.pid');
                //查询字段
                $data->select('supervision_transportations.id', 'supervision_transportations.name',
                    'supervision_transportations.head', 'supervision_transportations.phone',
                    //DB::raw('group_concat(supervision_brands.name) AS bname')
                    'supervision_companys.name AS bname','supervision_transportations.device_count'
                );

                //统计点位数量
                /*$data->withCount(['device' => function ($query) {
                    $query->where('type', 0);
                }]);*/
                $data->groupBy('supervision_transportations.id', 'supervision_transportations.name',
                    'supervision_transportations.head', 'supervision_transportations.phone',
                    'supervision_companys.name','supervision_transportations.device_count');
                $res = $data->offset($offset)
                    ->limit($post['page_size'])->get();
            } catch (\Exception $e) {
                Log::error($e);
                return Y::error("查询异常");
            }
            //查询时间段
            $t = AnalysisTime::where('department_id', $group_id);
            $t->where('type', 0);
            $t->select(DB::raw('GROUP_CONCAT(CONCAT(start_time,"-",end_time)) AS time'));
            $time = $t->first();
            $record = ['data' => $res, 'time' => $time['time'], 'current_page' => $post['page'],
                'page_size' => $post['page_size'], 'count' => $count];
            Log::info($record);
            return Y::success('查询成功', $record);
        } else {
            return view('admin.supervise.transportation');
        }
    }

    /**
     * Show the form for creating a new resource.
     * 获取监管转运中心列表
     * @return \Illuminate\Http\Response
     */
    public function dotList(Request $request)
    {
        //获取当前用户部门id
        $group_id = Auth::guard('admin')->user()->group_id;
        //$department_id = 1;
        //查询数据
        $data = Dot::orderBy('id', 'DESC');
        $data->where('department_id', $group_id);
        //查询数据
        try {
            $res = $data->get()->mapWithKeys(function ($item) {
                return [$item['id'] => $item['name']];
            });
            Log::info($res);
        }catch (\Exception $e){
            Log::error($e);
            return Y::error("查询异常");
        }
        return Y::success('查询成功', $res);
    }

    /**
     * Display a listing of the resource.
     * 显示人工巡检网点列表
     * @return \Illuminate\Http\Response
     */
    public function dot(Request $request)
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
            //$group_id = 33;
            Log::debug($post);

            //获取分页
            $offset = Help::offset($post['page_size'], $post['page']);
            //查询数据
            $data = Dot::orderBy('supervision_dots.id', 'DESC');
            $data->where('supervision_dots.department_id', $group_id);
            //判断是否有name
            /*if ($request->has('name') && !empty($post['name'])) {
                $data->where('supervision_dots.name', 'LIKE', '%' . $post['name'] . '%');
            }*/
            if ($request->has('id') && !empty($post['id'])) {
                $data->where('supervision_dots.id', $post['id'] );
            }
            //print_r($data->toSql());
            //exit();
            //查询数据
            try {
                //统计总数
                $count = $data->count();
                //左连接查询品牌
                /*$data->leftJoin('supervision_brands', function ($query) {
                    $query->whereRaw("find_in_set(supervision_brands.id, supervision_dots.brand_ids)");
                });*/
                $data->leftJoin('supervision_companys', 'supervision_companys.id', '=', 'supervision_dots.pid');
                //查询字段
                $data->select('supervision_dots.id', 'supervision_dots.name',
                    'supervision_dots.head', 'supervision_dots.phone', 'supervision_dots.level', 'supervision_dots.work_time',
                    //DB::raw('group_concat(supervision_brands.name) AS bname')
                    'supervision_companys.name AS bname', 'supervision_dots.device_count'
                );
                //统计点位数量
                /*$data->withCount(['device' => function ($query) {
                    $query->where('type', 1);
                }]);*/
                $data->groupBy('supervision_dots.id', 'supervision_dots.name',
                    'supervision_dots.head', 'supervision_dots.phone', 'supervision_dots.level',
                    'supervision_companys.name', 'supervision_dots.work_time','supervision_dots.device_count');
                $res = $data->offset($offset)
                    ->limit($post['page_size'])->get();
            } catch (\Exception $e) {
                Log::error($e);
                return Y::error("查询异常");
            }

            //print_r($data->toSql());
            //查询时间段
            $t = AnalysisTime::where('department_id', $group_id);
            $t->where('type', 1);
            $t->select(DB::raw('GROUP_CONCAT(CONCAT(start_time,"-",end_time)) AS time'));
            $time = $t->first();
            $record = ['data' => $res, 'time' => $time['time'], 'current_page' => $post['page'],
                'page_size' => $post['page_size'], 'count' => $count];
            Log::info($record);
            return Y::success('查询成功', $record);
        } else {
            return view('admin.supervise.transportation');
        }
    }

    //查看转运中心下设备列表
    public function device(Request $request)
    {
        $post = $request->post();
        //验证参数是否合法
        $validator = Validator::make($post, [
            'id' => 'required|integer',
            'type' => 'required|integer',
        ]);
        if ($validator->fails()) {
            Log::error($validator->errors());
            return Y::error($validator->errors());
        }
        //查询数据
        if ($post['type'] == 0) {
            $record = Transportation::find($post['id'])->device()->where('type', $post['type'])
                ->get(['id', 'name', 'cameraid'])->toarray();
        } else {
            $record = Dot::find($post['id'])->device()->where('type', 1)
                ->get(['id', 'name', 'cameraid'])->toarray();
        }
        return Y::success('查询成功', $record);
    }

    //查看设备详细信息
    public function show($id)
    {
        //设备详细信息
        $record = Device::find($id)->toarray();
        //查询时间段
        $t = AnalysisTime::where('department_id', $record['department_id']);
        $t->where('type', $record['type']);
        $t->select(DB::raw('CONCAT(start_time,"-",end_time) AS time'));
        $time = $t->get();
        $data['record'] = $record;
        $data['time'] = $time;
        return Y::success('查询成功', $data);
    }

    //修改网点信息
    public function updateDot(Request $request, $id)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->post();
            //验证参数是否合法
            $validator = Validator::make($post, [
                'work_time' => 'required',
                'level' => 'required|integer',
            ], [],
                ['work_time' => '工作时间', 'level' => '优先级']
            );
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            $data['work_time'] = $post['work_time'];
            $data['level'] = $post['level'];
            $model = Dot::find($id);
            //修改数据
            if ($model->update($data)) {
                Log::info('修改网点"' . $model->name . '"' . '成功');
                return Y::success('更新成功');
            }
            Log::error('修改网点"' . $model->name . '"' . '失败');
            return Y::success('更新失败');
        }
    }

    //修改设备详细信息
    public function updateDevice(Request $request, $id)
    {
        //判断请求方式
        if ($request->isMethod('post')) {
            $post = $request->post();
            //验证参数是否合法
            $validator = Validator::make($post, [
                'work' => 'required',
                'name' => 'required',
                'number' => 'required',
                'direction' => 'required',
                'frequency' => 'required|integer',
                'models' => 'required',
            ]);
            $name = $post['name'] . '-' . $post['work'] . '-' . $post['number'];
            $post['name'] = $name;
            if ($validator->fails()) {
                Log::error($validator->errors());
                return Y::error($validator->errors());
            }
            $model = Device::find($id);
            $params = [
                'AnalysisCfgId' => intval($model->id),
                'CamId' => strval($model->cameraid),
                'NodeId' => intval($model->nodeid),
                'Models' => strval($post['models']),
                'Frequency' => strval($post['frequency']),
                'Time' => strval($post['time'])
            ];
            //修改数据
            if ($model->update($post)) {
                $this->request('POST', 'analysis/update', $params);
                Log::info('修改设备"' . $model->name . '"' . '成功');
                return Y::success('更新成功');
            }
            Log::error('修改设备"' . $model->name . '"' . '失败');
            return Y::success('更新失败');
        }
    }

    //获取区域列表
    public function region()
    {
        $data = config('custom.region');
        Log::info($data);
        return Y::success('查询成功', $data);
    }

}
