<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\LinkModel;

class LinkController extends Controller
{
    protected $link_model = null;

    public function __construct()
    {
        $this->link_model = new LinkModel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $links = $this->link_model->getLinks();
        return view('admin.link.index')->with('links', $links);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.link.add');
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
        $res = $this->link_model->insertLink($data);
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
        $link = $this->link_model->getLink($id);
        return view('admin.link.edit', ['link' => $link]);
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
        $res = $this->link_model->updateLink($id, $data);
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
        $res = $this->link_model->delLink($id);
        if ($res) {
            return ['msg' => '删除成功', 'status' => 'success'];
        } else {
            return ['msg' => '删除失败', 'status' => 'fail'];
        }
    }
}
