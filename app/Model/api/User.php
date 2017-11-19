<?php
/**
 * Created by PhpStorm.
 * User: qianke
 * Date: 2017/11/15 0015
 * Time: 上午 10:48
 */

namespace App\Model\api;


class User extends BaseModel
{
    protected $fillable=['name','phone','password'];

}