<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\CateModel;

class CateController extends Controller
{
    protected $cate_model = null;

    public function __construct()
    {
        $this->cate_model = new CateModel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cates = $this->cate_model->getCates();
        return view('admin.cate.index', ['cates' => $cates]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cate.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $res = $this->cate_model->insertCate($data);
        if ($res) {
            return ['msg' => '添加成功', 'status' => 'success'];
        } else {
            return ['msg' => '添加失败', 'status' => 'fail'];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cate = $this->cate_model->getCate($id);
        return view('admin.cate.edit')->with('cate', $cate);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token', '_method');
        $res = $this->cate_model->updateCate($id, $data);
        if ($res) {
            return ['msg' => '更新成功', 'status' => 'success'];
        } else {
            return ['msg' => '更新失败', 'status' => 'fail'];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = $this->cate_model->delCate($id);
        if ($res) {
            return ['msg' => '删除成功', 'status' => 'success'];
        } else {
            return ['msg' => '删除失败', 'status' => 'fail'];
        }
    }
}
