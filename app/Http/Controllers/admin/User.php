<?php

namespace App\Http\Controllers\admin;

use App\Model\admin\Admin;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Input;
use Session;
use \Illuminate\Http\Request;

class User extends BaseController
{
    public $builder;
    //登录
    public static function login()
    {
        return view('admin/login');
    }
    //验证码
    public function showCaptcha(Request $request)
    {
        $this->builder = new CaptchaBuilder();
        $this->builder->build(150,32);
        //获取验证码内容
        $phrase = $this->builder->getPhrase();
        //把内容存入session
        $request->session()->put('qkCaptcha', $phrase); //存储验证码
        ob_clean(); //清除缓存
        return response($this->builder->output())->header('Content-type','image/jpeg'); //把验证码数据以jpeg图片的格式输出
    }
    //确认登录信息
    public function doLogin(Request $request)
    {
        $Input = $request->all();
        $admin['admin'] = $Input['admin'];
        $Id = Admin::where('name',$Input['admin'])->select('id')->get()->toArray();
        $admin['id'] = $Id[0]['id'];
        $pwd = $Input['pwd'];
        $captcha = $Input['captcha'];

        if(empty($captcha))
        {
            return back()->with('msg','验证码不能为空');
        }
        if(empty($admin))
        {
            return back()->with('msg','用户名不能为空');
        }
        if(empty($pwd))
        {
            return back()->with('msg','密码不能为空');
        }
        //数据库验证
        $verify = Admin::doLogin($admin,md5($pwd));
        if ($request->session()->get('qkCaptcha') == $captcha)
        {

            if($verify)
            {
                $request->session()->put('admin',$admin);
                return redirect('admin/');
            }
            else
            {
                return back()->with('msg','用户名或密码错误');
            }
        }else
        {
            //用户输入验证码错误
            return back()->with('msg','验证码错误');
        }
    }
    //登出
    public function logout(Request $request)
    {
        $request->session()->put('admin',null);
        return redirect('admin/login');
    }
}
