<?php
/**
 * Created by PhpStorm.
 * User: qianke
 * Date: 2017/11/15 0015
 * Time: 上午 0:34
 */

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Model\admin\AdminPermission as PermissionModel;
class Permission extends BaseController
{
    public function info()
    {
        $data = PermissionModel::paginate(10);
        return view('admin/permission/list',['data'=>$data]);
    }
    // 添加
    public function add(Request $request)
    {
        if($request->isMethod('post')){
            $input = $request->all();
            $res = PermissionModel::create($input);
            if($res) {
                return Redirect('admin/permission');
            }
            else {
                return back()->with([
                    'msg'=>'添加失败，请稍后重试',
                    'data'=>$input
                ]);
            }
        }
        return view('admin/permission/add');
    }
    //修改
    public function edit(Request $request)
    {
        if($request->isMethod('post')){
            $input = $request->all();

            $res = PermissionModel::edit($input);
            if($res){
                return Redirect('admin/permission');
            }else{
                return back()->with([
                    'msg'=>'修改失败，请稍后重试',
                    'data'=>$input
                ]);
            }
        }
        $id = $request->all('get.id');
        $data =PermissionModel::find($id)->toArray();
        $data['id'] = $id;
        return view('admin/permission/update',['data'=>$data[0]]);
    }
    //删除
    public function delete(Request $request)
    {
        $id = $request->get('id');
        //根据主键找到要删除的cart
        $res = PermissionModel::where('id',$id)->delete();
        if($res){
            return Redirect('/admin/permission');
        }else{
            return back()->with('msg','删除失败，请稍后重试');
        }

    }
}