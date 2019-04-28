<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ImageModel;

class ImageController extends Controller
{
    protected $image_model = null;

    //初始化Model
    public function __construct()
    {
        $this->image_model = new ImageModel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $res = $this->image_model->getImages();
        return view('admin.image.index')->with('images', $res);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.image.add');
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
        $res = $this->image_model->insertImage($data);
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
        $image = $this->image_model->getImage($id);
        return view('admin.image.edit')->with('image', $image);
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
        $res = $this->image_model->upImage($id, $data);
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
        $res = $this->image_model->delImage($id);
        if ($res) {
            return ['msg' => '删除成功', 'status' => 'success'];
        } else {
            return ['msg' => '删除失败', 'status' => 'fail'];
        }
    }

    //图片上传
    public function upload(Request $request)
    {
        $image = $request->file('file');
        if ($image->isValid()) {//验证图片的合法性
            $ext = $image->getClientOriginalExtension();
            $size = $image->getClientSize();
            $allow_ext = ['png', 'jpeg', 'gif', 'jpg'];
            $allow_size = 1024 * 1024 * 2;
            if (!in_array($ext, $allow_ext) || $size > $allow_ext) {
                return false;
            }

            $path = 'uploads/' . date('Y-m-d');
            $image_name = time() . '.' . $ext;
            if ($image->move($path, $image_name)) {
                $url = $path . '/' . $image_name;
                return ['status' => 'success', 'url' => $url];
            }


        }
    }
}
