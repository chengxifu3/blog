<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AdminModel;
use App\Model\UserModel;

class UserController extends Controller
{
    public function index(){
        $user_model = new UserModel;
        $users = $user_model->getUsers();
        //dump($users);die;
        return view('admin.user.index',['users'=>$users]);
    }

    public function pass(Request $request){
        if($request->isMethod('post')){
            $new_pass = trim($request->input('newpass'));
            $admin_name = session('admin_name');
            $adminModel = new AdminModel;
            $res = $adminModel->updatePass($admin_name,$new_pass);
            if($res){
                return ['msg'=>'密码修改成功','status'=>'success'];
            }else{
                return ['msg'=>'密码修改失败','stauts'=>'fail'];
            }
        }
        return view('admin.user.pass');
    }

    //删除用户
    public function delUser($id){
        $user_model = new UserModel;
        $res = $user_model->delUser($id);
        if($res){
            return ['msg'=>'用户删除成功','status'=>'success'];
        }else{
            return ['msg'=>'用户删除失败','stauts'=>'fail'];
        }
    }

    //冻结用户
    public function freezeUser($id){
        $user_model = new UserModel;
        $res = $user_model->freezeUser($id);
        if($res){
            return ['msg'=>'操作成功','status'=>'success'];
        }else{
            return ['msg'=>'操作失败','stauts'=>'fail'];
        }
    }

}
