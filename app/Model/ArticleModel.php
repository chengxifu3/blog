<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class ArticleModel extends Model
{
    protected $table = 'article';
    protected $dateFormat = 'U';

    //插入文章
    public function insertArticle($data)
    {
        $this->title = $data['title'];
        $this->cate_id = $data['cate_id'];
        $this->desc = $data['desc'];
        $this->author = $data['author'];
        $this->keywords = $data['keywords'];
        $this->image_url = $data['image_url'];
        $this->content = $data['content'];
        $res = $this->save();
        return $res;
    }

    //查询所有的文章
    public function getArticles()
    {
        $res = DB::table('article as a')->join('cate as c', 'a.cate_id', '=', 'c.id')->select('a.id', 'a.title', 'a.views', 'a.image_url', 'a.updated_at', 'c.name')->paginate(2);
        return $res;
    }

    //查询一条文章信息
    public function getArticle($id)
    {
        return self::find($id)->toArray();
    }

    //删除文章
    public function delArticle($id)
    {
        return self::destroy($id);
    }

    //更新文章
    public function updateArticle($id, $data)
    {
        return self::where('id', $id)->update($data);
    }

    //获取文章关键字
    public function getKeywords()
    {
        return self::pluck('keywords')->toArray();
    }

    //获取所有文章列表
    public function getIndexArt()
    {
        return self::select('id', 'title', 'desc', 'image_url')->orderBy('id', 'desc')->paginate(2);
    }

    //获取最新文章列表
    public function getNewArticles()
    {
        return self::select('id', 'title')->orderBy('id', 'desc')->get(5);
    }

    //获取文章分类列表
    public function getCateList($id)
    {
        return self::where('cate_id', $id)->select('id', 'title', 'desc', 'image_url')->orderBy('id', 'desc')->paginate(1);
    }

    //前台获取文章详情
    public function getArt($id)
    {
        $res = self::find($id);
        if ($res) {
            return $res->toArray();
        } else {
            return ['status' => 'fail'];
        }
    }

    //给文章增加浏览量
    public function viewInc($id)
    {
        self::where('id', $id)->increment('views');
    }

    //获取当前文章的上一篇文章
    public function getPreArt($id)
    {
        $res = self::where('id', '<', $id)->select('id', 'title')->orderBy('id', 'desc')->first();
        return $res;
    }

    //获取当前文章的下一篇文章
    public function getNextArt($id)
    {
        $res = self::where('id', '>', $id)->select('id', 'title')->orderBy('id', 'desc')->first();
        return $res;
    }

    //用户给文章点赞
    public function insertDiggit($username, $id)
    {
        //获取用户id
        $uid = DB::table('user')->where('username', $username)->value('id');
        $res = DB::table('diggit')->insert(['uid' => $uid, 'article_id' => $id]);
        if ($res) {
            self::where('id', $id)->increment('diggits');
            return self::where('id', $id)->value('diggits');
        }
    }

    //检查用户是否已经点赞过了
    public function checkDiggit($username, $id)
    {
        //获取用户id
        $uid = DB::table('user')->where('username', $username)->value('id');
        $res = DB::table('diggit')->where('uid', $uid)->where('article_id', $id)->first();
        if ($res) {
            return false;
        } else {
            return true;
        }
    }

    //添加文章评论
    public function insertComment($data)
    {
        return DB::table('comment')->insert($data);
    }

    //获取文章评论列表
    public function getComment($id)
    {
        $res = DB::table('comment')->where('article_id', $id)->select('username', 'content', 'created_at')->get(5);
        if ($res) {
            return $res->toArray();
        } else {
            return [];
        }
    }

    //获取文章评论的条数
    public function getCommentNum($id)
    {
        return DB::table('comment')->where('article_id', $id)->count();
    }

    //获取每个分类里的文章
    public function getArtcilByCate()
    {
        $res = DB::select('select a.cate_id,count(a.id) as num from blog_article a left join blog_cate c on a.cate_id=c.id group by a.cate_id');
        return $res;
    }

    //获取文章评论
    public function getComments()
    {
        $res = DB::table('comment as c')->join('article as a', 'c.article_id', '=', 'a.id')->select('c.id', 'a.title', 'c.username', 'c.created_at', 'c.content')->orderBy('c.id', 'desc')->paginate(2);
        return $res;
    }

    //删除留言
    public function delComment($id)
    {
        $res = DB::table('comment')->where('id', $id)->delete();
        return $res;
    }

    //获取搜索文章列表
    public function getArticleBySearch($keyword)
    {
        $res = self::where('title', 'like', '%' . $keyword . '%')->orWhere('content', 'like', '%' . $keyword . '%')->select('id', 'title', 'image_url', 'desc')->get()->toArray();
        return $res;
    }

}
