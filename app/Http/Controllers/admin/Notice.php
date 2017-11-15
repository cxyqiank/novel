<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use \App\Model\admin\Notice as NoticeModel;

class Notice extends BaseController
{
    //公告列表
    public function info()
    {
        $data = NoticeModel::paginate(3);
        return view('admin/notice/noticeList',['data'=>$data]);
    }
    //notice添加
    public function add(Request $request)
    {
        if($request->isMethod('post')){
            $input = $request->all();
            //添加进notice表
            $res = NoticeModel::create($input);
            if($res) {
                return Redirect('admin/notice/info');
            }
            else {
                return back()->with('msg','添加失败，请稍后重试');
            }
        }
        return view('admin/notice/addNotice');
    }
    //notice修改
    public function edit(Request $request)
    {
        if($request->isMethod('post')){
            $input = $request->all();
            //修改notice表
            $res = NoticeModel::edit($input);
            if($res){
                return Redirect('admin/notice/info');
            }else{
                return back()->with('msg','修改失败，请稍后重试');
            }
        }
        $id = $request->all('get.id');
        $data = NoticeModel::find($id)->toArray();
        $data['id'] = $id;
        return view('admin/notice/upNotice',['data'=>$data[0]]);
    }
    //notice删除
    public function delete(Request $request)
    {
        $id = $request->get('id');
        //根据主键找到要删除的notice
        $res = NoticeModel::where('id',$id)->delete();
        if($res){
            return Redirect('admin/notice/info');
        }else{
            return back()->with('msg','删除失败，请稍后重试');
        }

    }
}
