<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CateModel extends Model
{
    public $timestamps = false;
    protected $table = 'cate';

    //插入分类
    public function insertCate($data)
    {
        return self::insert($data);
    }

    //查询所有的分类
    public function getCates()
    {
        return self::get()->toArray();
    }

    //查询一条分类信息
    public function getCate($id)
    {
        return self::find($id)->toArray();
    }

    //更新分类信息
    public function updateCate($id, $data)
    {
        return self::where('id', $id)->update($data);
    }

    //删除分类信息
    public function delCate($id)
    {
        return self::destroy($id);
    }
}
