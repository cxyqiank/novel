<?php
/**
 * Created by PhpStorm.
 * User: qianke
 * Date: 2017/11/19 0019
 * Time: 上午 9:20
 */

namespace App\Model\api;


class Collection extends BaseModel
{
    public $timestamps = false;
    public static function add($id,$book_id)
    {
        $data = self::where('user_id',$id)->get(['content']);
        $data = unserialize($data[0]['content']);
        $data = array_push($data,$book_id);
        return self::where('user_id',$id)->update('content',serialize($data));
    }

    public static function del($id,$book_id)
    {
        $data = self::where('user_id',$id)->get(['content']);
        $data = unserialize($data[0]['content']);
        $data = array_diff($data,$book_id);
        return self::where('user_id',$id)->update('content',serialize($data));
    }
}