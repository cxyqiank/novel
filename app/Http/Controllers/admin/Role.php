<?php
/**
 * Created by PhpStorm.
 * User: qianke
 * Date: 2017/11/15 0015
 * Time: 上午 0:34
 */

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Model\admin\AdminRole as RoleModel;
use \App\Model\admin\AdminPermission as PermissionModel;
class Role extends BaseController
{
    public function info()
    {
        $data = RoleModel::paginate(3);
        return view('admin/role/roleList',['data'=>$data]);
    }
    // 添加
    public function add(Request $request)
    {
        if($request->isMethod('post')){
            $input = $request->all();
            //添加进cart表
            $res = RoleModel::create($input);
            if($res) {
                return Redirect('admin/role-info');
            }
            else {
                return back()->with([
                    'msg'=>'添加失败，请稍后重试',
                    'data'=>$input
                ]);
            }
        }
        return view('admin/role/addRole');
    }
    //修改
    public function edit(Request $request)
    {
        if($request->isMethod('post')){
            $input = $request->all();
            //修改cart表
            $res = RoleModel::edit($input);
            if($res){
                return Redirect('admin/role-info');
            }else{
                return back()->with([
                    'msg'=>'添加失败，请稍后重试',
                    'data'=>$input
                ]);
            }
        }
        $id = $request->all('get.id');
        $data =RoleModel::find($id)->toArray();
        $data['id'] = $id;
        return view('admin/role/upRole',['data'=>$data[0]]);
    }
    //删除
    public function delete(Request $request)
    {
        $id = $request->get('id');
        //根据主键找到要删除的cart
        $res = RoleModel::where('id',$id)->delete();
        if($res){
            return Redirect('admin/role-info');
        }else{
            return back()->with('msg','删除失败，请稍后重试');
        }

    }

    // 权限
    public function grant(RoleModel $role)
    {
        $permissions = PermissionModel::all();
        $myPermissions =$role->permissions;
        return view('admin/role/permission',compact('permissions','myPermissions','role'));
    }
    // 执行
    public function store(RoleModel $role)
    {
        $permissions = PermissionModel::findMany(request('permissions'));
        $myPermissions = $role->permissions;
        //增加
        $addPermissions = $permissions->diff($myPermissions);
        foreach($addPermissions as $addPermission) {
            $role->grantPermission($addPermission);
        }

        //删除
        $delPermissions = $myPermissions->diff($permissions);
        foreach($delPermissions as $delPermission) {
            $res2 = $role->deletePermission($delPermission);
        }

        return back();
    }
    //分配权限
    public function permission(Request $request)
    {
        $input = $request->all();
        $role = RoleModel::with('permissions')->where('id',$input['id'])->get(['*'])->toArray();
        $hasPermission = array_column($role[0]['permissions'],'pivot');
        $hasPermission = array_column($hasPermission,'permission_id');
        if($request->isMethod('get'))
        {
            $permissions = PermissionModel::all();
            return view('admin/role/permission',compact('permissions','role','hasPermission'));
        }elseif ($request->isMethod('post')){
            $newPer = $input['permissions'];
            $del = array_diff($hasPermission,$newPer);
            (new RoleModel())->deletePermission($del);
            $insert = array_diff($newPer,$hasPermission);
            (new RoleModel())->grantPermission($insert);
            return back()->with(['msg'=>'授权成功']);
        }
    }

}