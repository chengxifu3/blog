<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $dateFormat = 'U';

    //插入用户信息
    public function insertUser($username, $password)
    {
        $salt = str_random(6);
        $password = md5($password . $salt);
        $this->username = $username;
        $this->password = $password;
        $this->salt = $salt;
        return $this->save();
    }

    //查询一条用户信息
    public function getUser($username)
    {
        $res = self::where('username', $username)->first();
        return $res;
    }

    //用户登录
    public function checkUser($username, $password)
    {
        $user = self::where('username', $username)->first();
        if (!$user) {
            return ['status' => 'fail', 'msg' => '此用户不存在'];
        }
        if ($user['status'] == 0) {
            return ['status' => 'fail', 'msg' => '此用户被冻结'];
        }
        $pass = md5($password . $user['salt']);
        if ($user['password'] != $pass) {
            return ['status' => 'fail', 'msg' => '密码不正确'];
        }
        session(['username' => $username]);
        return ['status' => 'success', 'msg' => '登录成功'];
    }

    //后台用户列表
    public function getUsers()
    {
        return self::select('id', 'username', 'created_at', 'updated_at', 'status')->orderBy('id', 'desc')->paginate(2);
    }

    //删除用户
    public function delUser($id)
    {
        return self::destroy($id);
    }

    //冻结/解冻用户
    public function freezeUser($id)
    {
        $status = self::where('id', $id)->value('status');
        $status = intval(!$status);
        $res = self::where('id', $id)->update(['status' => $status]);
        return $res;
    }
}
