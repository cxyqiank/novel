<?php

namespace App\Http\Controllers\api\controllers\v1;

use App\Http\Controllers\Controller;
use App\Model\api\Collection;
use App\Model\api\Novel;
use Illuminate\Support\Facades\Response;


class Shelf extends Controller
{
    public function shelf()
    {
        $token = request('token');

        $id = UserAPI::getUser($token);
        if($id==null){
            return Response::json(['status'=>0]);
        }
        $data = \App\Model\api\shelf::where('user_id',$id)->get(['content']);
        $data = unserialize($data[0]['content']);
        $data = $this->getBooks(array_values($data));
        return Response::json($data);
    }
    # 收藏
    public function collectors()
    {
        $token = request('token');

        $id = UserAPI::getUser($token);
        if($id==null){
            return Response::json(['status'=>0]);
        }
        //验证数据
        $data = Collection::where('user_id',$id)->get(['content']);
        $data = unserialize($data[0]['content']);
        $data = $this->getBooks(array_values($data));
        return Response::json($data);

    }
    public function getBooks($ids)
    {
        $data = Novel::whereIn('id',$ids)
            ->get(['id','name','pic','desc'])
            ->toArray();
        return $data;
    }
}
