<?php
/**
 * Created by PhpStorm.
 * User: qianke
 * Date: 2017/11/14 0014
 * Time: 下午 23:37
 */

namespace App\Model\admin;


class Novel_cart extends BaseModel
{
    protected $table='novel_carts';
    protected $fillable = ['novel_id','cart_id'];
    public $timestamps =false;
    public static function add($novel_id,$cart_id)
    {
        $cart_id = Cart::where('name',$cart_id)->get(['id'])->toArray();
        $data['novel_id'] = $novel_id;
        $data['cart_id'] = $cart_id[0]['id'];
        return $res = self::create($data);
    }
}