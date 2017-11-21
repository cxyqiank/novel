<?php

namespace App\Http\Controllers\api\controllers\v1;

use App\Http\Controllers\Controller;
use App\Model\api\Banner;
use App\Model\api\Hot;
use App\Model\api\Notice;
use App\Model\api\Novel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class IndexAPI extends Controller
{
    //首页接口
    public function indexAPI()
    {
        //热门图书
        //$data['hots'] = \App\Model\admin\novel::whereIn('id',[hot::orderBy('collectors','desc')->take(4)->get(['id'])])->get(['name','pic']);
        $hot = Hot::orderBy('collectors','desc')->take(4)->get(['id'])->toArray();
        $data['hots'] = Novel::whereIn('id',$hot)->get(['name','pic']);

        return Response::json($data);
    }
    //公告
    public function indexNotice()
    {
        //公告
        $data['notices'] = Notice::orderBy('updated_at','desc')->take(3)->get(['content']);
        return Response::json($data);
    }
    //banner
    public function indexBanner()
    {
        //轮播图
        $data['banners'] = Banner::orderBy('id','desc')->take(4)->get(['item','pic']);
        return Response::json($data);
    }
    //HotRead
    public function indexHot()
    {
        $sql = 'SELECT n.id,n.name,n.pic,n.author FROM novels n 
LEFT JOIN hots h ON n.id = h.novel_id 
ORDER BY h.collectors desc LIMIT 5';
        $data['novels'] = DB::select($sql);
        return $data;
    }
    public function indexNews()
    {
        $data['news'] = Novel::orderBy('updated_at','desc')->take(5)->get();
        return $data;
    }
    public function indexDescs()
    {
        $ids = Novel::where('status',0)
            ->take(5)->get(['id'])->toArray();
        $data = [];
        foreach($ids as $id){
            $data[]= \App\Model\admin\Novel::info($id);
        }
        for($i=0;$i<count($data);$i++){
           $carts = implode('|',array_column($data[$i]['cart'],'name'));
           $data[$i]['carts'] = $carts;
        }
        return $data;
    }

    public function hotAuthor()
    {
        $sql = 'SELECT count(n.name) nums,n.author,count(h.visitors) vs,count(h.collectors) cs 
FROM novels n LEFT JOIN hots h ON n.id = h.novel_id GROUP BY n.author ORDER BY cs desc LIMIT 3';
        $data = DB::select($sql);
        return Response::json($data);
    }
}
