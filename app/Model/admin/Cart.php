<?php

namespace App\Model\admin;


class Cart extends BaseModel
{
    protected $fillable = ['name','desc'];
    public $timestamps = false;
    public static function info($novel_id)
    {
        $cart_id = Novel_cart::where('novel_id',$novel_id)
            ->get(['cart_id'])
            ->toArray();
        $cart = Cart::where('id',$cart_id[0]['cart_id'])
            ->get(['name'])
            ->toArray();
        return $cart[0]['name'];
    }
    public static function edit($input)
    {
        unset($input['_token']);
        return self::where('id',$input['id'])->update($input);
    }
}