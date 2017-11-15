<?php
/**
 * Created by PhpStorm.
 * User: qianke
 * Date: 2017/11/14 0014
 * Time: 下午 23:44
 */

namespace App\Http\Controllers\admin;

use App\Model\admin\Cart as CartModel;
use Illuminate\Http\Request;


class Cart extends BaseController
{
    //公告列表
    public function info()
    {
        $data = CartModel::paginate(3);
        return view('admin/cart/cartList',['data'=>$data]);
    }
    // 添加
    public function add(Request $request)
    {
        if($request->isMethod('post')){
            $input = $request->all();

            //添加进cart表
            $res = CartModel::create($input);
            if($res) {
                return Redirect('admin/cart/info');
            }
            else {
                return back()->with('msg','添加失败，请稍后重试');
            }
        }
        return view('admin/cart/addCart');
    }
    //修改
    public function edit(Request $request)
    {
        if($request->isMethod('post')){
            $input = $request->all();
            //修改cart表
            $res = CartModel::edit($input);
            if($res){
                return Redirect('admin/cart/info');
            }else{
                return back()->with('msg','修改失败，请稍后重试');
            }
        }
        $id = $request->all('get.id');
        $data =CartModel::find($id)->toArray();
        $data['id'] = $id;
        return view('admin/cart/upCart',['data'=>$data[0]]);
    }
    //删除
    public function delete(Request $request)
    {
        $id = $request->get('id');
        //根据主键找到要删除的cart
        $res = CartModel::where('id',$id)->delete();
        if($res){
            return Redirect('admin/cart/info');
        }else{
            return back()->with('msg','删除失败，请稍后重试');
        }

    }
}