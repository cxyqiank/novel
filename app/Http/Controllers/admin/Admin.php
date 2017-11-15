<?php
/**
 * Created by PhpStorm.
 * User: qianke
 * Date: 2017/11/15 0015
 * Time: 上午 0:34
 */

namespace App\Http\Controllers\admin;

use App\Model\admin\Admin as AdminModel;
use Illuminate\Http\Request;

class Admin extends BaseController
{
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
            $input['password'] = md5($input['password']);
            //添加进cart表
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
            $input['password'] = md5($input['password']);
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
}