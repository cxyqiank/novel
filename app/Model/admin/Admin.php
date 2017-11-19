<?php

namespace App\Model\admin;


use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;

use Session;

class Admin extends User
{
    protected $rememberTokenName = '';
    protected $guarded = [];
    # 用户有哪些角色
    public function roles()
    {
        return $this->belongsToMany(\App\Model\admin\AdminRole::class,'admin_role_user','user_id','role_id')
            ->withPivot(['user_id','role_id']);
    }
    # 判断是否有某角色
    public function isInRoles($roles)
    {
        ## 两个!!为正，变成boolean
        return !! $roles->intersect($this->roles)->count();
    }
    # 给用户分配角色 直接调用属性就会保存
    public function assignRole($role)
    {
        return $this->roles()->save($role);
    }
    # 用户取消与某角色的关联
    public function deleteRole($role)
    {
        return $this->roles()->detach($role);
    }
    # 用户是否有权限
    public function hasPermission($permission)
    {
        return $this->isInRoles($permission->roles);
    }

    # 后台用户登录验证
    public static function doLogin($name,$pwd)
    {
        $password = self::where('name',$name)->get(['password'])->toArray();
       try{
            $password = $password[0]['password'];
            $res = Hash::check($pwd,$password);
            return $res;
        }catch (\Exception $e){
            return false;
        }
}

    protected $fillable = ['name','password','role_id'];

    public static function edit($input)
    {
        unset($input['_token']);
        return self::where('id',$input['id'])->update($input);
    }
}
