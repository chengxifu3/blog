<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ImageModel extends Model
{
    protected $table = 'image';
    public $timestamps = false;

    //插入幻灯片
    public function insertImage($data)
    {
        return self::insert($data);
    }

    //查询所有的幻灯片
    public function getImages()
    {
        return self::get()->toArray();
    }

    //查询一条幻灯片信息
    public function getImage($id)
    {
        return self::find($id)->toArray();
    }

    //更新幻灯片
    public function upImage($id, $data)
    {
        return self::where('id', $id)->update($data);
    }

    //删除一个幻灯片
    public function delImage($id)
    {
        return self::destroy($id);
    }

    //查询排序后的幻灯片信息
    public function getImagesBySort()
    {
        return self::select('title', 'url', 'image_url')->orderBy('sort', 'asc')->get()->toArray();
    }


}
