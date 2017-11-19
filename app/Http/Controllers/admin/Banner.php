<?php

namespace App\Http\Controllers\admin;

use App\Model\admin\BaseModel;
use Illuminate\Http\Request;
use \App\Model\admin\Banner as BannerM;

class Banner extends BaseController
{
    //banner列表
    public function info()
    {
        $data = BannerM::paginate(4);
        return view('admin/banner/bannerList',['data'=>$data]);
    }
    //banner添加
    public function add(Request $request)
    {
        if($request->isMethod('post')){
            $input = $request->all();
            //1.接收文件
            $file = $request->file('pic');
            $path = 'bannerPic';
            //文件上传
            $input = BaseModel::uploadPic($input,$file,$path);
            //添加进banner表
            $res = BannerM::create($input);
            if($res){
                return Redirect('admin/banner/info');
            }
            else{
                return back()->with('msg','添加失败，请稍后重试');
            }
        }
        return view('admin/banner/addBanner');
    }
    //banner更新
    public function update(Request $request)
    {
        if($request->isMethod('post')){
            $input = $request->all();
            $file = $request->file('address');
            $res = BannerM::updateBanner($input,$file);
            if($res){
                return Redirect('admin/banner/info');
            }
            else{
                return back()->with('msg','更新失败，请稍后重试');
            }
        }
        $id = $request->get('id');
        $data = BannerM::find($id);
        return view('admin/banner/upBanner',['data'=>$data]);
    }
    //banner删除
    public function delete(Request $request)
    {
        $id = $request->get('id');
        //根据主键找到要删除的banner
        $res = BannerM::where('id',$id)->delete();
        if($res){
            //跳转
            return Redirect('admin/banner/info');
        }else{
            //添加失败
            return back()->with('msg','删除失败，请稍后重试');
        }
    }
    //批量删除
    public static function multiDel(Request $request)
    {
        BannerM::destroy($request->get('ids'));
        return redirect('/admin/banner/info');
    }
}
