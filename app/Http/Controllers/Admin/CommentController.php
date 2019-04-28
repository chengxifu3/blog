<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ArticleModel;

class CommentController extends Controller
{
    /**
     * 留言列表
     */
    public function index()
    {
        $article_model = new ArticleModel;
        $comments = $article_model->getComments();
        return view('admin.comment.index', ['comments' => $comments]);
    }

    /**
     * 删除留言
     */
    public function delComment($id)
    {
        $article_model = new ArticleModel;
        $res = $article_model->delComment($id);
        if ($res) {
            return ['status' => 'success', 'msg' => '删除成功'];
        } else {
            return ['status' => 'fail', 'msg' => '删除失败'];
        }
    }
}
