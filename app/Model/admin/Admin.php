<?php

namespace App\Model\admin;

use Session;

class Admin extends BaseModel
{
    //后台用户登录验证
    public static function doLogin($name,$pwd)
    {
        $admin = new Admin();
        $res = $admin->where('name',$name)->get(['name','password'])->toArray();

        if($res)
        {
            if($res[0]['password']==$pwd)
            {
                Session::put('admin',$res[0]['name']);
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    protected $fillable = ['name','password'];

    public static function edit($input)
    {
        unset($input['_token']);
        return self::where('id',$input['id'])->update($input);
    }
}
