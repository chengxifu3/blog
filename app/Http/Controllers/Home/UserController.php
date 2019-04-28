<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Model\UserModel;

class UserController extends Controller
{
    protected $user_model = null;

    public function __construct()
    {
        $this->user_model = new UserModel;
    }

    //用户登录
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            //接收验证码并验证
            $code = trim($request->input('code'));
            $rule = ['code' => 'captcha'];
            $message = ['code.captcha' => '验证码不正确'];
            $validator = Validator::make(['code' => $code], $rule, $message);
            if ($validator->fails()) {
                $msg = $validator->errors()->first();
                return ['status' => 'fail', 'msg' => $msg];
            }
            $username = trim($request->input('username'));
            $password = trim($request->input('password'));
            $res = $this->user_model->checkUser($username, $password);
            return $res;

        }
        return view('home.user.login');
    }

    //用户注册
    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            //验证码验证
            $code = trim($request->input('code'));
            $rule = ['code' => 'captcha'];
            $message = ['code.captcha' => '验证码不正确'];
            $validtor = Validator::make(['code' => $code], $rule, $message);
            if ($validtor->fails()) {
                $msg = $validtor->errors()->first();
                return ['status' => 'fail', 'msg' => $msg];
            }
            //获取用户和密码
            $username = trim($request->input('username'));
            $password = trim($request->input('password'));
            $res = $this->user_model->insertUser($username, $password);
            if ($res) {
                session(['username' => $username]);
                return ['msg' => '注册成功', 'status' => 'success'];
            } else {
                return ['msg' => '注册失败', 'status' => 'fail'];
            }

        }
        return view('home.user.register');
    }

    public function check(Request $request)
    {
        $username = trim($request->input('param'));
        $res = $this->user_model->getUser($username);
        if ($res) {
            return ['info' => '用户已存在', 'status' => 'n'];
        } else {
            return ['info' => '可以注册', 'status' => 'y'];
        }
    }

    //用户退出
    public function logout()
    {
        session(['username' => null]);
        return redirect('login');
    }
}
