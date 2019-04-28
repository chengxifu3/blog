<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{
    protected $table = 'admin';
    public $timestamps = false;

    public function checkLogin($admin_name, $admin_pass)
    {
        $user = self::where('admin_name', $admin_name)->select('admin_pass', 'salt')->first();
        if (!$user) {
            return ['msg' => '此用户名不存在', 'status' => 'fail'];
        }
        $pass = md5($admin_pass . $user['salt']);
        $user = $user->toArray();
        if ($user['admin_pass'] == $pass) {
            return ['msg' => '登录成功！', 'status' => 'success'];
        }
        return ['msg' => '密码不正确', 'status' => 'fail'];
    }

    //检测密码
    public function checkPass($admin_name, $admin_pass)
    {
        $res = $this->checkLogin($admin_name, $admin_pass);
        return $res;
    }

    //更新管理员密码
    public function updatePass($admin_name, $new_pass)
    {
        $salt = str_random(6);
        $admin_pass = md5($new_pass . $salt);
        $res = self::where('admin_name', $admin_name)->update(['salt' => $salt, 'admin_pass' => $admin_pass]);
        return $res;
    }

}
