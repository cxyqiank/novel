<?php

namespace App\Model\api;

class Hot extends BaseModel
{
    //首页接口
    public function indexAPI()
    {
        //猜你喜欢，默认为最新上架
        header('Access-Control-Allow-Origin:*');
        $data['likeRead'] = \App\Model\admin\novel::orderBy('id','desc')->take(4)->get(['name','pic']);
        //热门图书
        //$data['hots'] = \App\Model\admin\novel::whereIn('id',[hot::orderBy('collectors','desc')->take(4)->get(['id'])])->get(['name','pic']);
        $hot = hot::orderBy('collectors','desc')->take(4)->get(['id'])->toArray();
        $data['hots'] = \App\Model\admin\novel::whereIn('id',$hot)->get(['name','pic']);
        //公告
        $data['notices'] = \App\Model\admin\notice::orderBy('updated_at','desc')->take(3)->get(['author','content']);
        //轮播图
        $data['banners'] = \App\Model\admin\banner::orderBy('id','desc')->take(4)->get(['item','address']);
        return Response::json($data);
    }
}
