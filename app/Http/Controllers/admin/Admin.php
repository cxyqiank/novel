<?php
/**
 * Created by PhpStorm.
 * User: qianke
 * Date: 2017/11/15 0015
 * Time: 上午 0:34
 */

namespace App\Http\Controllers\admin;

use App\Model\admin\Admin as AdminModel;
use App\Model\admin\AdminRole;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;

class Admin extends BaseController
{
    public $builder;
    //登录
    public static function login()
    {
        if(!Session::has('admin')){
            return view('admin/login');
        }else{
            return redirect('/admin');
        }
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
        $Input['id'] = AdminModel::where('name',$Input['admin'])
            ->get(['id'])->toArray();
        $Input['id'] = $Input['id'][0]['id'];

        $admin['name'] = $Input['admin'];
        $admin['password'] = $Input['pwd'];
        $captcha = $Input['captcha'];
        $validator = Validator::make($request->all(), [
            'admin'     => 'required|min:5',
            'pwd'       => 'required|min:5',
            'captcha'   => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        if ($request->session()->get('qkCaptcha') == $captcha)
        {
//            Auth::guard('admin')->attempt($admin)
            if(Auth::attempt($admin)){
                Session::put('admin',$Input);
                return redirect('/admin');
            }else{
                return back()->with('msg','用户名密码不正确');
            }
        }else{
            return back()->with('msg','验证码错误');
        }

    }
    //登出
    public function logout(Request $request)
    {
        $request->session()->put('admin',null);
        return redirect('login');
    }

    public function info()
    {
        $data = AdminModel::paginate(3);
        return view('admin/admin/adminList',['data'=>$data]);
    }
    // 添加
    public function add(Request $request)
    {
        if($request->isMethod('post')){
            $input = $request->all();
            $validator = Validator::make($request->all(), [
                'name'      => 'required|min:5',
                'password'  => 'required|min:5',
            ]);
            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $input['password'] = bcrypt($input['password']);

            $res = AdminModel::create($input);
            if($res) {
                return Redirect('admin/info');
            }
            else {
                return back()->with('msg','添加失败，请稍后重试');
            }
        }
        return view('admin/admin/addAdmin');
    }
    //修改
    public function edit(Request $request)
    {
        if($request->isMethod('post')){
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            //修改cart表
            $res = AdminModel::edit($input);
            if($res){
                return Redirect('admin/info');
            }else{
                return back()->with('msg','修改失败，请稍后重试');
            }
        }
        $id = $request->all('get.id');
        $data =AdminModel::find($id)->toArray();
        $data['id'] = $id;
        return view('admin/admin/upAdmin',['data'=>$data[0]]);
    }
    //删除
    public function delete(Request $request)
    {
        $id = $request->get('id');
        //根据主键找到要删除的cart
        $res = AdminModel::where('id',$id)->delete();
        if($res){
            return Redirect('admin/info');
        }else{
            return back()->with('msg','删除失败，请稍后重试');
        }

    }
    // 角色
    public function grant(AdminModel $user)
    {
        $roles = AdminRole::all();
        $myRoles =$user->roles;
        return view('admin/admin/grant',compact('roles','myRoles','user'));
    }
    // 存储用户角色
    public function store(AdminModel $user)
    {
        $roles = AdminRole::findMany(request('roles'));
        $myRoles = $user->roles;
        //增加
        $addRoles = $roles->diff($myRoles);

        foreach($addRoles as $addRole) {
            $user->assignRole($addRole);
        }

        //删除
        $delRoles = $myRoles->diff($roles);
        foreach($delRoles as $delRole) {
            $res2 = $user->deleteRole($delRole);
        }

        return back();
    }
}