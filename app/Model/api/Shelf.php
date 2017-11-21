<?php

namespace App\Model\api;

class shelf extends BaseModel
{
    protected $table='shelfs';
    public $timestamps=false;
    public static function add($id,$book_id)
    {
        $data = self::where('user_id',$id)->get(['content']);
        $data = unserialize($data[0]['content']);
        array_push($data,$book_id);
        return self::where('user_id',$id)->update(['content'=>serialize($data)]);
    }

    public static function del($id,$book_id)
    {
        $data = self::where('user_id',$id)->get(['content']);
        $data = unserialize($data[0]['content']);
        $data = array_diff($data,[$book_id]);
        return self::where('user_id',$id)->update('content',serialize($data));
    }
}
