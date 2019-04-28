<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ArticleModel;
use Validator;

class ArticleController extends Controller
{
    protected $article_model = null;

    public function __construct()
    {
        $this->article_model = new ArticleModel;
    }

    //文章列表页
    public function index($id)
    {
        $articles = $this->article_model->getCateList($id);
        return view('home.article.index', ['articles' => $articles]);
    }

    //文章详情页
    public function detail($id)
    {
        $article = $this->article_model->getArt($id);
        if (isset($article['status']) && $article['status'] == 'fail') {
            return redirect('/');
        }
        //获取文章评论
        $comments = $this->article_model->getComment($id);
        //获取文章评论的条数
        $comment_num = $this->article_model->getCommentNum($id);
        $preArt = $this->article_model->getPreArt($id);
        $nextArt = $this->article_model->getNextArt($id);
        $this->article_model->viewInc($id);
        return view('home.article.detail', ['article' => $article, 'preArt' => $preArt, 'nextArt' => $nextArt, 'comments' => $comments, 'comment_num' => $comment_num]);
    }

    //点赞
    public function diggit($id)
    {
        //判断用户是否登录
        if (!session('username')) {
            return ['status' => 'nologin', 'msg' => '请先去登录，再来点赞'];
        }
        $username = session('username');
        //判断用户是否点赞过
        if (!$this->article_model->checkDiggit($username, $id)) {
            return ['status' => 'fail', 'msg' => '你已经点赞过了'];
        }
        $res = $this->article_model->insertDiggit($username, $id);
        if ($res) {
            return ['status' => 'success', 'num' => $res];
        }
    }

    //文章评论
    public function comment(Request $request)
    {
        if (!session('username')) {
            return ['status' => 'nologin', 'msg' => '请先登录，再来评论'];
        }
        //验证验证码
        $code = trim($request->input('code'));
        $rule = ['code' => 'captcha'];
        $message = ['code.captcha' => '验证码不正确'];
        $validator = Validator::make(['code' => $code], $rule, $message);
        if ($validator->fails()) {
            return ['status' => 'fail', 'msg' => $validator->errors()->first()];
        }

        //组装数据
        $data['username'] = session('username');
        $data['article_id'] = $request->input('id');
        $data['content'] = trim($request->input('content'));
        $data['created_at'] = time();
        $res = $this->article_model->insertComment($data);
        if ($res) {
            return ['status' => 'success', 'msg' => '评论成功'];
        }

    }

    //文章搜索
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $articles = $this->article_model->getArticleBySearch($keyword);
        return view('home.article.search', ['articles' => $articles]);
    }


}
