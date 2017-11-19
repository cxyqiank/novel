<?php

namespace App\Model\admin;

use Illuminate\Database\Eloquent\Model;

class AdminPermission extends Model
{
    protected $table = 'admin_permissions';
    protected $fillable = ['name','description'];
    # 权限属于哪个角色
    public function roles()
    {
        return $this->belongsToMany(\App\Model\admin\AdminRole::class,'admin_permission_role','permission_id','role_id')
            ->withPivot(['permission_id','role_id']);
    }
    public static function edit($input)
    {
        unset($input['_token']);
        return self::where('id',$input['id'])->update($input);
    }
}
