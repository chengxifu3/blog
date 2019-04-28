<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Model\SystemModel;
use View;
use App\Model\ArticleModel;
use App\Model\LinkModel;
use App\Model\CateModel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //获取网站配置信息
        $sys_model = new SystemModel;
        $system = $sys_model->getSys();
        //获取文章关键字
        $article_model = new ArticleModel;
        $keywords = $article_model->getKeywords();
        //获取友情链接
        $link_model = new LinkModel;
        $links = $link_model->getLinksBySort();
        //获取最新文章
        $articles = $article_model->getNewArticles();
        //获取文章分类
        $cate_model = new CateModel;
        $cates = $cate_model->getCates();
        View::share(['system' => $system, 'keywords' => $keywords, 'links' => $links, 'articles' => $articles, 'cates' => $cates]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
