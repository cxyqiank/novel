<?php

namespace App\Model\admin;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    protected $table = 'admin_roles';
    protected $fillable=['name','description'];
    # 获取当前角色的所有权限
    public function permissions()
    {
        return $this->belongsToMany(\App\Model\admin\AdminPermission::class,'admin_permission_role','role_id','permission_id')
            ->withPivot(['permission_id','role_id']);
    }
    # 授权
    public function grantPermission($permissions)
    {
        return $this->permissions()->save($permissions);
    }
    # 取消权限
    public function deletePermission($permission)
    {
        return $this->permissions()->detach($permission);
    }
    # 是否有权限
    public function hasPermission($permission)
    {
        return $this->permissions->contains($permission);
    }
    public static function edit($input)
    {
        unset($input['_token']);
        return self::where('id',$input['id'])->update($input);
    }
}
