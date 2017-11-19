<?php
/**
 * Created by PhpStorm.
 * User: qianke
 * Date: 2017/11/17 0017
 * Time: 上午 8:35
 */

namespace App\Model\api;


class NovelCart extends BaseModel
{
    protected $table='novel_carts';
    public function cart()
    {
        return $this->belongsTo(\App\Model\api\Cart::class,'cart_id','id');
    }

    public function novel()
    {
        return $this->belongsTo(\app\Model\api\Novel::class,'novel_id','id');
    }
}