<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ImageModel;
use App\Model\ArticleModel;

class IndexController extends Controller
{
    public function index()
    {
        //获取幻灯片信息
        $image_model = new ImageModel;
        $images = $image_model->getImagesBySort();
        //获取所有文章信息
        $article_model = new ArticleModel;
        $articles = $article_model->getIndexArt();
        return view('home.index', ['articles' => $articles])->with('images', $images);
    }
}
