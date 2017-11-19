<?php


namespace App\Model\api;


class Cart extends BaseModel
{
    protected $table = 'carts';
    public function novelCart()
    {
        return $this->hasMany(NovelCart::class,'cart_id','id');
    }
}