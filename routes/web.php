<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//后台登录页面
Route::get('admin/login', 'Admin\LoginController@index');

//处理登录
Route::post('admin/toLogin', 'Admin\LoginController@login');
//后台退出
Route::get('admin/logout', 'Admin\LoginController@logout');
//后台首页
Route::get('admin/index', 'Admin\IndexController@index')->middleware('login');
//修改密码时检测原密码
Route::post('admin/checkPass', 'Admin\LoginController@checkPass')->middleware('login');

//网站设置
Route::get('admin/system', 'Admin\SystemController@index')->middleware('login');
Route::match(['get', 'post'], 'admin/system/edit', 'Admin\SystemController@edit')->middleware('login');

//后台轮播图
Route::resource('admin/image', 'Admin\ImageController')->middleware('login');
Route::post('admin/upload', 'Admin\ImageController@upload')->middleware('login');

//友情链接
Route::resource('admin/link', 'Admin\LinkController')->middleware('login');

//留言管理
Route::get('admin/comment', 'Admin\CommentController@index')->middleware('login');

//内容管理
Route::resource('admin/article', 'Admin\ArticleController')->middleware('login');
Route::post('article/upload', 'Admin\ArticleController@upload')->middleware('login');
//文章图表
Route::get('admin/art/chart', 'Admin\ArticleController@chart')->middleware('login');
Route::get('admin/art/chart_list', 'Admin\ArticleController@chart_list')->middleware('login');
//留言管理
Route::get('admin/comment', 'Admin\CommentController@index')->middleware('login');
//删除留言
Route::get('admin/delComment/{id}', 'Admin\CommentController@delComment')->middleware('login');
//分类管理
Route::resource('admin/cate', 'Admin\CateController')->middleware('login');

//用户管理
Route::get('admin/user', 'Admin\UserController@index')->middleware('login');
//后台删除用户
Route::get('admin/user/delUser/{id}', 'Admin\UserController@delUser')->middleware('login');
//冻结用户
Route::get('admin/freezeUser/{id}', 'Admin\UserController@freezeUser')->middleware('login');

//修改密码
Route::match(['get', 'post'], 'admin/pass', 'Admin\UserController@pass')->middleware('login');

//前台首页
Route::get('/', 'Home\IndexController@index');

//前台文章列表页
Route::get('article/list/{id}', 'Home\ArticleController@index')->where('id', '\d+');
//前台文章详情页
Route::get('article/detail/{id}', 'Home\ArticleController@detail')->where('id', '[0-9]+');

//前台用户登录注册
Route::match(['get', 'post'], 'login', 'Home\UserController@login');
Route::match(['get', 'post'], 'register', 'Home\UserController@register');
//验证前台用户名是否存在
Route::post('check', 'Home\UserController@check');
//用户退出
Route::get('logout', 'Home\UserController@logout');
//用户给文章点赞
Route::get('artilce/diggit/{id}', 'Home\ArticleController@diggit');
//用户给文章评论
Route::post('article/comment', 'Home\ArticleController@comment');

//前台文章搜索
Route::post('article/search', 'Home\ArticleController@search');
