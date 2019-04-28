<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\SystemModel;

class SystemController extends Controller
{
    protected $sys_model = null;

    public function __construct()
    {
        $this->sys_model = new SystemModel;
    }

    public function index()
    {

        $res = $this->sys_model->getSys();
        return view('admin.system.index', ['sys' => $res]);
    }

    public function edit(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->except('_token');
            $res = $this->sys_model->upSys($data);
            if ($res) {
                return ['msg' => '修改成功', 'status' => 'success'];
            } else {
                return ['msg' => '修改失败', 'status' => 'fail'];
            }
        } else {
            $sys_model = new SystemModel;
            $res = $sys_model->getSys();
            return view('admin.system.edit', ['sys' => $res]);
        }
    }
}
