<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\CateModel;
use App\Model\ArticleModel;
use DB;

class ArticleController extends Controller
{
    protected $article_model = null;

    public function __construct()
    {
        $this->article_model = new ArticleModel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = $this->article_model->getArticles();
        return view('admin.article.index')->with('articles', $articles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cate_model = new CateModel;
        $cates = $cate_model->getCates();
        return view('admin.article.add')->with('cates', $cates);
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
        //$data['created_at'] = time();
        $res = $this->article_model->insertArticle($data);
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
        $cate_model = new CateModel;
        $cates = $cate_model->getCates();
        $article = $this->article_model->getArticle($id);
        return view('admin.article.edit', ['cates' => $cates])->with('article', $article);
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
        $res = $this->article_model->updateArticle($id, $data);
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
        $res = $this->article_model->delArticle($id);
        if ($res) {
            return ['msg' => '删除成功', 'status' => 'success'];
        } else {
            return ['msg' => '删除失败', 'status' => 'fail'];
        }
    }

    //文章内部里的图片上传
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

            $path = 'article/' . date('Y-m-d');
            $image_name = time() . '.' . $ext;
            if ($image->move($path, $image_name)) {
                $url = '/' . $path . '/' . $image_name;
                return ['errno' => 0, 'data' => [$url]];
            }


        }
    }

    //文章图表
    public function chart()
    {
        return view('admin.article.chart');
    }

    public function chart_list()
    {
        $res = $this->article_model->getArtcilByCate();
//dump($res);die;
        if ($res) {
            $data['status'] = 1;
            $data['msg'] = '获取成功';
            $data['title'] = '文章数据统计';
            foreach ($res as $v) {
                $data['result']['name'][] = DB::table('cate')->where('id', $v->cate_id)->value('name');
                $data['result']['num'][] = $v->num;
            }
        } else {
            $data['status'] = 0;
            $data['msg'] = '获取失败';
            $data['result'] = null;
        }
        exit(json_encode($data));
    }
}
