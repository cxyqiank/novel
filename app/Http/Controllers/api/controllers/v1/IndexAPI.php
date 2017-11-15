<?php

namespace App\Http\Controllers\api\controllers\v1;

use App\Http\Controllers\Controller;
use App\Model\api\banner;
use App\Model\api\hot;
use App\Model\api\notice;
use App\Model\api\novel;
use Illuminate\Support\Facades\Response;

class IndexAPI extends Controller
{
    // //首页接口
    public function indexAPI()
    {
        //猜你喜欢，默认为最新上架
        header('Access-Control-Allow-Origin:*');
        $data['likeRead'] = novel::orderBy('id','desc')->take(4)->get(['name','pic']);
        //热门图书
        //$data['hots'] = \App\Model\admin\novel::whereIn('id',[hot::orderBy('collectors','desc')->take(4)->get(['id'])])->get(['name','pic']);
        $hot = hot::orderBy('collectors','desc')->take(4)->get(['id'])->toArray();
        $data['hots'] = novel::whereIn('id',$hot)->get(['name','pic']);
        //公告
        $data['notices'] = notice::orderBy('updated_at','desc')->take(3)->get(['author','content']);
        //录播图
        $data['banners'] = banner::orderBy('id','desc')->take(4)->get(['item','address']);
        return Response::json($data);
    }
}
