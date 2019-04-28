<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LinkModel extends Model
{
    protected $table = 'link';
    public $timestamps = false;

    //查询所有友情链接
    public function getLinks()
    {
        return self::get()->toArray();
    }

    //插入友情链接
    public function insertLink($data)
    {
        return self::insert($data);
    }

    //查询一条友情链接信息
    public function getLink($id)
    {
        return self::find($id)->toArray();
    }

    //更新友情链接
    public function updateLink($id, $data)
    {
        return self::where('id', $id)->update($data);
    }

    //删除友情链接
    public function delLink($id)
    {
        return self::destroy($id);
    }

    //获取排序后的友情链接
    public function getLinksBySort()
    {
        return self::select('title', 'url')->orderBy('sort', 'asc')->get()->toArray();
    }

}
