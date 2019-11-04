<?php

namespace App\Http\Controllers\Admin;

use App\Library\Y;
use App\Model\Admin;
use App\Service\Email;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use App\Model\Department;
use App\Library\Tree;
use Illuminate\Support\Facades\Log;
use App\Service\Sms;
use Illuminate\Support\Facades\DB;
class AdminController extends Controller
{


    /**
     * 用户列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            #获取分页参数
            $post = $request->post();
            Log::debug($post);
            if(!isset($post['username'])||$post['username'] == NULL) {
                $post['username'] = "";
            }
            $validator = Validator::make($post, [
                'page' => 'required|int',
                'page_size' => 'required|int',
                'username' =>'string'
            ], [], ['page' => '页码', 'page_size' => '分页显示数量','username'=>'用户名']);
            if ($validator->fails()) {
                return Y::error($validator->errors());
            }
            #判断当前用户角色（系统管理员，单位管理员，单位业务员）
            $role_id = Auth::guard('admin')->user()->roles[0]->id;
            $user_id = Auth::guard('admin')->user()->id;
            $group_id = Auth::guard('admin')->user()->group_id;
            #系统管理员，可以查询所有人员
            if ($role_id == 1) {
                try {
                    $admin = Admin::where([['admins.id', '!=', $user_id],
                            ['admins.nickname','LIKE','%'.$post['username']."%"]]
                    )->leftjoin('departments','departments.id','=','admins.group_id');

                } catch (\Exception $e) {
                    Log::error($e);
                    return Y::error("查询异常");
                }
            } #单位管理员,只能管理下属管理员和业务员
            else if ($role_id == 2) {
                $res = $this->checkDepartment();
                if ($res == 0) {
                    #国家级管理员可以管理省级管理员和业务员
                    #查询省级的组织id
                    $group_ids = Department::where('pid', '1')->get()->map(function ($value) {
                        return $value->id;
                    });
                    #执行查询
                    try {
                        $admin = Admin::where([['admins.id', '!=', $user_id],
                            ['admins.nickname','like','%'.$post['username']."%"]])
                            ->wherein('admins.group_id', $group_ids)
                            ->leftjoin('departments','id','=','admins.group_id');
                    } catch (\Exception $e) {
                        Log::error($e);
                        return Y::error("查询异常");
                    }
                } else if ($res == 1) {
                    #省级管理员能管理市级管理员和业务员
                    #查询到该用户所属的组织的下属地级市id
                    $group_ids = Department::where('pid', $group_id)->get()->map(function ($value) {
                        return $value->id;
                    });
                    #执行查询
                    try {
                        $admin = Admin::where([['admins.id', '!=', $user_id],
                            ['admins.nickname','like','%'.$post['username']."%"]])
                            ->wherein('admins.group_id', $group_ids)
                            ->leftjoin('departments','departments.id','=','admins.group_id');
                    } catch (\Exception $e) {
                        Log::error($e);
                        return Y::error("查询异常");
                    }
                } else if ($res == 2) {
                    #市级管理员只能管理市级的业务员
                    #执行查询
                    try {
                        $admin = Admin::where('admins.group_id', $group_id)
                            ->select('admins.*','departments.name')
                            ->leftJoin('model_has_roles', 'admins.id', '=', 'model_has_roles.model_id')
                            ->leftjoin('departments','departments.id','=','admins.group_id')
                            ->where([['model_has_roles.role_id', '3'], ['admins.id', '!=', $user_id],
                                ['admins.nickname','like','%'.$post['username']."%"]]);
                    } catch (\Exception $e) {
                        Log::error($e);
                        return Y::error("查询异常");
                    }
                } else {
                    Log::info("管理员列表查询异常");
                    return Y::error("查询异常");
                }
            }else{
                Log::info("当前用户没有查询用户权限");
                return Y::error("您没有查询用户权限");
            }
            #判断用户是否点击组织机构进行过滤
            if(isset($post['group_id'])&&$post['group_id'] != NULL) {
                $re = $this->checkDepartment($post['group_id']);
                #点击了省级 系统管理员
                if($re == 1 && $role_id == 1){
                    $admin = $admin->where('departments.pid',$post['group_id']);
                }
                #点击了省级 国家管理员
                else if($re ==1 && $this->checkDepartment() == 0){
                    $admin = $admin->where('departments.pid',$post['group_id']);
                }
                #点击了市级
                else if($re ==2){
                    $admin = $admin->where('admins.group_id',$post['group_id']);
                }
            }
            $count = $admin->count();
            $record = $admin->select("admins.*",'departments.name')
                ->offset(($post['page'] - 1) * $post['page_size'])
                ->limit($post['page_size'])->get();
            $result = ['data' => $record, 'current_page' => $post['page'], 'page_size' => $post['page_size'], 'total' => $count];
            return Y::success("成功", $result);
        }
        return view('admin.rbac.admin.index_list');

    }


    //添加管理员
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $post = $request->post();
            Log::debug($post);
            $validator = Validator::make($post, [
                'username' => 'required|unique:admins|max:32',
                'nickname' => 'required|max:64',
                'password' => 'required|min:6|max:16',
                'email'    => 'required|email',
                'mobile'    => 'required',
                'roles' => 'array',
                'group_id' => 'required|int'
            ], [], ['group_id' => '组织机构']);
            if ($validator->fails()) {
                return Y::error($validator->errors());
            }
            $post['password'] = bcrypt($post['password']);
            $post['sex'] = 0;
            $post['card_id'] = "513701199202102333";
            #单位业务员组织结构只能是市级
            $group_type = $this->checkDepartment($post['group_id']);
//            if($post['roles'][0] == 3 && $group_type !=2){
//                return Y::error('单位业务员所属组织只能是市级');
//            }
            #系统管理员接受前端手动选择角色
            $admin = Admin::create($post);
            if ($admin && $post['roles']) {
                $admin->syncRoles($post['roles']);
            }
            return Y::success('添加成功');
        } else {
            $roles = Role::all();
            #获取组织机构属性结构
            $role_id = Auth::guard('admin')->user()->roles[0]->id;
            $group_id = Auth::guard('admin')->user()->group_id;
            #系统管理员
            if ($role_id == 1) {
                $group_list = Department::all()->toArray();
                $group_list = Tree::unlimitForLevel($group_list);
            } else if ($role_id == 2) {
                #单位管理员可以添加下属单位的管理员和业务员
                #国家级管理员可以选择省
                $res = $this->checkDepartment();
                if ($res == 0) {
                    $group_list = Department::where('pid', '1')->get()->toArray();
                    $group_list = Tree::unlimitForLevel($group_list, "", '1');
                } #省级管理员只能选择地级市，市的只能添加业务员
                else if ($res == 1) {
                    $pid = $group_id;
                    $group_list = Department::where('pid', $pid)->get()->toArray();
                    $group_list = Tree::unlimitForLevel($group_list, "", $pid);
                } else if ($res == 2) {
                    #地级市隐藏组织选择，默认当前管理员所属组织
                    $group_list = [];
                } else {
                    return Y::page('添加异常,请稍后重试');
                }
            }else{
                return Y::page('您没有当前操作权限');
            }
            #确认是否是市级管理员
            $res = Department::where('id', $group_id)->get();
            if ($res[0]->pid != 0 && $res[0]->pid != 1) {
                $city = 1;
            } else {
                $city = 0;
            }
            return view('admin.rbac.admin.add', [
                'roles'      => $roles,
                'city'       => $city,
                'group_list' => $group_list,
                'group_id'   => $group_id,
                'role_id'    => Auth::guard('admin')->user()->roles[0]->id
            ]);
        }
    }

    //修改管理员
    public function edit(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $post = $request->only(['nickname', 'password', 'roles', 'group_id']);
            Log::debug($post);
            $validator = Validator::make($post, [
                'nickname' => 'required|max:64',
                'roles' => 'array',
                'group_id' => 'required|int'
            ], [], ['group_id' => '组织机构']);
            if ($validator->fails()) {
                return Y::error($validator->errors());
            }
            $admin = Admin::find($id);
            if (empty($post['password'])) {
                unset($post['password']);
            } else {
                $post['password'] = bcrypt($post['password']);
            }
            #单位业务员组织结构只能是市级
            $group_type = $this->checkDepartment($post['group_id']);
            if($post['roles'][0] == 3 && $group_type !=2){
                return Y::error('单位业务员所属组织只能是市级');
            }
            if ($admin->update($post)) {
                #系统管理员才能修改角色
                #获取当前用户的id
                $user_id = Auth::guard('admin')->user()->id;
                if ($user_id == 1) {
                    $admin->roles()->detach();
                    if (!empty($post['roles'])) {
                        $admin->syncRoles($post['roles']);
                    }
                }
                Log::info("管理员信息更新成功");
                return Y::success('更新成功');
            }
            Log::info("管理员信息更新失败");
            return Y::error('更新失败');
        } else {
            #当前权限
            $city = 0;
            $role_id = Auth::guard('admin')->user()->roles[0]->id;
            $admin = Admin::findOrFail($id);
            $roles = Role::all();
            $has_roles = [];
            if ($admin->roles) {
                $has_roles = $admin->roles->map(function ($role) {
                    return $role->id;
                })->toArray();
            }
            #获取组织机构属性结构
            $user_id = Auth::guard('admin')->user()->id;
            $group_id = Auth::guard('admin')->user()->group_id;
            #系统管理员
            if ($role_id == 1) {
                $group_list = Department::all()->toArray();
                $group_list = Tree::unlimitForLevel($group_list);
            } else if($role_id == 2){
                #单位管理员，省级可以选择下属市，市级默认本市
                $res = Department::where('id', $group_id)->get();
                #省级
                if ($res[0]->pid == 1) {
                    $group_list = Department::where('pid', $group_id)->get()->toArray();
                    $group_list = Tree::unlimitForLevel($group_list, "", $group_id);
                }
                #级市
                else {
                    $group_list = Department::where('id', $group_id)->get()->toArray();
                    $group_list = Tree::unlimitForLevel($group_list, "", $group_id);
                    $city = 1;
                }
            }else{
                return Y::page("你没有访问权限");
            }
            #获取当前用户的id 前端过滤是否是系统管理员
            return view('admin.rbac.admin.edit', [
                'admin'     => $admin,
                'roles'     => $roles,
                'city'      => $city,
                'has_roles' => $has_roles,
                'group_list'=> $group_list,
                'group_id'  => $group_id,
                'id'        => $user_id,
                'role_id'   => Auth::guard('admin')->user()->roles[0]->id
            ]);
        }
    }

    //删除
    public function delete($id)
    {
        if (Admin::destroy($id) > 0) {
            Log::info("管理员删除成功");
            return Y::success('删除成功');
        }
        Log::info("管理员删除失败");
        return Y::error('删除失败');
    }

    //个人信息
    public function me(Request $request)
    {
        if ($request->isMethod('post')) {
            $post = $request->post();
            Log::debug($post);
            $validator = Validator::make($post, [
                'nickname' => 'max:64',
                'face'     => 'max:128',
                'email'    => 'unique:admins,email,' . $request->user()->id . '|string|email|max:255',
                'password' => 'min:6|max:16|confirmed',
                'mobile'    => 'unique:admins,mobile,' . $request->user()->id . '|regex:/^1[34578][0-9]{9}$/',
            ]);
            if ($validator->fails()) {
                return Y::error($validator->errors());
            }
            unset($post['password_confirmation']);
            $data = [];
            foreach ($post as $key => $val) {
                if (!empty($val)) {
                    $data[$key] = $val;
                }
            }
            if (isset($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }
            if (Admin::where('id', $request->user()->id)->update($data) > 0) {
                Log::info("用户个人信息修改成功");
                return Y::success('修改成功');
            }
            Log::info("用户个人信息修改失败");
            return Y::error('修改失败');
        } else {
            return view('admin.rbac.admin.me', [
                'user' => Auth::user()
            ]);
        }
    }

    //更改用户状态
    public function status(Request $request)
    {
        if ($request->isMethod('post')) {
            $post = $request->post();
            Log::debug($post);
            $validator = Validator::make($post, [
                'username' => 'required|string|max:32',
                'status'   => 'required|int'
            ]);
            if ($validator->fails()) {
                return Y::error($validator->errors());
            }
            #执行修改操作，返回结果
            $res = Admin::where('username', $post['username'])->update($post);
            if ($res) {
                Log::info("用户状态更新成功");
                return Y::success('状态更新成功');
            }
            Log::info("用户状态更新失败");
            return Y::error('状态更新失败');

        }
    }
    /*
     * 绑定/更换手机号
     * @param Request $request
     * @return json
     */
     public function bdMobile(Request $request)
     {
         if ($request->isMethod('post')) {
             #获取当前登录的id,验证手机号
             $post = $request->post();
             Log::debug($post);
             $validator = Validator::make($post, [
                 'mobile' => 'required|unique:admins,mobile,' . $request->user()->id . '|regex:/^1[34578][0-9]{9}$/',
             ]);
             if ($validator->fails()) {
                 return Y::error($validator->errors());
             }
             #发送验证码
             if (Sms::sendCode($post['phone'], $type = 'bd_phone')) {
                 Log::info("验证短信发送成功");
                 return Y::success("验证短信发送成功");
             }
             Log::info("验证短信发送失败");
             return Y::error("验证短信发送失败");
         }
     }
    /*
    * 验证绑定手机短信验证码
    */
    public function checkPhoneCode(Request $request){
        if ($request->isMethod('post')) {
            $post = $request->only('mobile','code');
            $validator = Validator::make($post, [
                'code'    => 'required|int|min:100000|max:999999',
                'mobile'  => 'required|regex:/^1[34578][0-9]{9}$/',
            ], [],["code"=>"验证码","mobile"=>"手机号码"]);
            if ($validator->fails()) {
                return Y::error($validator->errors()->first());
            }
            #验证验证码合法和正确
            $ret = Sms::check($post['mobile'], 'bd_phone', $post['code']);
            if($ret != ''){
                return Y::error($ret);
            }
            unset($post['code']);
            #验证成功，完成绑定手机操作
            try{
                $res = Admin::where('id', $request->user()->id)->update($post);
            }catch (\Exception $e) {
                Log::error($e);
                return Y::error("绑定手机异常,请稍后重试");
            }
            if($res > 0){
                Log::info("绑定手机成功");
                return Y::success("绑定手机成功");
            }
            Log::info("绑定失败");
            return Y::error("绑定失败");

        }
    }
    /*
    * 绑定/更换邮箱
    * @param Request $request
    * @return json
    */
    public function bdEmail(Request $request){
        if ($request->isMethod('post')) {
            #验证邮箱
            $post = $request->post();
            Log::debug($post);
            $validator = Validator::make($post, [
                'email'    => 'required|unique:admins,email,' . $request->user()->id . '|string|email|max:255',
            ]);
            if ($validator->fails()) {
                return Y::error($validator->errors());
            }
            #发送验证码
            if (Email::bdEmail($post['email'],"绑定邮箱")){
                Log::info("邮箱验证码发送成功");
                return Y::success("邮箱验证码发送成功");
            }
            Log::info("邮箱验证码发送失败");
            return Y::error("邮箱验证码发送失败");
        }
    }

    /*
    * 绑定/更换邮箱验证
    * @param Request $request
    * @return json
    */
    public function checkEmailCode(Request $request){
        if ($request->isMethod('post')) {
            $post = $request->only('mobile', 'code');
            $validator = Validator::make($post, [
                'code'  => 'required|int|min:100000|max:999999',
                'email' => 'required|string|email|max:255',
            ], [], ["code" => "验证码", "email" => "邮箱"]);
            if ($validator->fails()) {
                return Y::error($validator->errors()->first());
            }
            #验证邮箱验证码是否正确
            $ret = Email::checkEmail($post['email'],$post['code']);
            if($ret != ''){
                return Y::error($ret);
            }
            unset($post['code']);
            #验证成功，完成绑定邮箱操作
            try{
                $res = Admin::where('id', $request->user()->id)->update($post);
            }catch (\Exception $e) {
                Log::error($e);
                return Y::error("绑定邮箱异常,请稍后重试");
            }
            if($res > 0){
                Log::info("绑定邮箱成功");
                return Y::success("绑定邮箱成功");
            }
            Log::info("绑定失败");
            return Y::error("绑定失败");
        }
    }

}
