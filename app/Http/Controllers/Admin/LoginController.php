<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Model\AdminModel;

class LoginController extends Controller
{
    //登录
    public function index()
    {
        return view('admin.login');
    }

    //处理登录
    public function login(Request $request)
    {
//        if(session('admin_name')){
//           // dd('slfjslaf');
//            return view('admin.index');
//        }
        //获取验证码并验证
        $code = trim($request->input('code'));
        $rule = ['code' => 'captcha'];
        $message = ['code.captcha' => '验证码输入不正确'];
        $validator = Validator::make(['code' => $code], $rule, $message);
        if ($validator->fails()) {
            $msg = $validator->errors()->first();
            return ['msg' => $msg, 'status' => 'fail'];
        }

        //获取用户名和密码
        $admin_name = trim($request->input('admin_name'));
        $admin_pass = trim($request->input('admin_pass'));

        //使用模型验证用户名和密码是否正确
        $adminModel = new AdminModel;
        $res = $adminModel->checkLogin($admin_name, $admin_pass);

        //记录用户的登录状态
        session(['admin_name' => $admin_name]);
        return $res;
    }

    //退出
    public function logout()
    {
        session(['admin_name' => null]);
        return redirect('admin/login');
    }

    //检测密码
    public function checkPass(Request $request)
    {
        //使用模型验证密码是否正确
        $adminModel = new AdminModel;
        $admin_name = session('admin_name');
        $admin_pass = trim($request->input('param'));
        $res = $adminModel->checkPass($admin_name, $admin_pass);
        if ($res['status'] == 'success') {
            return ['info' => '密码正确，可以修改', 'status' => 'y'];
        } else {
            return ['info' => '密码不正确', 'status' => 'n'];
        }
    }
}
