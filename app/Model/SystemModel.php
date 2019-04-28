<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SystemModel extends Model
{
    protected $table = 'system';
    public $timestamps = false;

    public function getSys()
    {
        $res = self::first()->toArray();
        return $res;
    }

    public function upSys($data)
    {
        $res = self::where('id', $data['id'])->update($data);
        return $res;
    }
}
