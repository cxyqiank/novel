<?php

namespace App\Http\Controllers\admin;

use App\Model\admin\Cart;
use App\Model\admin\Novel as NovelModel;
use \App\model\admin\Section as SectionModel;
use Illuminate\Http\Request;
use Session;

class Novel extends BaseController
{
    //后台首页
    public static function index()
    {
        $data = NovelModel::index();

        return view('admin/index',['data'=>$data]);
    }
    //小说列表
    public function lists()
    {
        $NovelModel = new NovelModel();
        $data = $NovelModel->lists();
        return view('admin/novel/lists',['data'=>$data]);
    }
    //小说添加
    public function add(Request $request)
    {
        if($request->isMethod('post')){
            date_default_timezone_set('PRC');
            $input = $request->all();
            $file = $request->file('pic');
            $res = NovelModel::add($input,$file);
            if($res){
                return Redirect('admin/novel/lists');
            }else {
                return back()->with('msg','添加失败，请稍后重试');
            }
        }
        //获取分类
        $data = Cart::all();
        return view('admin/novel/add',['data'=>$data]);
    }
    //小说信息修改
    public function update(Request $request)
    {
        if($request->isMethod('post'))
        {
            $input = $request->all();
            $res = NovelModel::edit($input);
            if($res){
                return Redirect('admin/novel/lists');
            }else{
                return back()->with('msg','修改失败，请稍后重试');
            }
        }
        $id = $request->all('get.id');
        $novel = NovelModel::find($id);
        $novel['id'] = $id;
        return view('admin/novel/update',['data'=>$novel[0]]);
    }
    //小说删除
    public function delete(Request $request)
    {
        $input = $request->all();
        $res = NovelModel::del($input);
        if($res){
            return Redirect('admin/novel/lists');
        }else{
            return back()->with('msg','删除失败');
        }
    }
    //小说信息
    public function info(Request $request)
    {
        $input = $request->all();
        $data = NovelModel::info($input['id']);
        $data['section'] = SectionModel::where('novel_id',$input['id'])
            ->get(['section_name','address'])
            ->toArray();
//        dd($data);
        return view('admin/novel/info',['data'=>$data]);
    }
    //展示小说章节
    public function show()
    {
        $page = $_GET['page'];
        $chars = $page*760;
        $ad = $_GET['ad'].'Section'.($_GET['section']+1).'.txt';
        $str = NovelModel::show($ad);
        mb_internal_encoding("UTF-8");
        $return['content'] = mb_substr($str,$chars,760);
        $return['page'] = $page;
        return $return;
    }
    //批量删除
    public static function multiDel(Request $request)
    {
        $v = [];
        foreach ($request->get('ids') as $v['id']){
            NovelModel::del($v);
        }
        return redirect('/admin/novel/lists');
    }
}
