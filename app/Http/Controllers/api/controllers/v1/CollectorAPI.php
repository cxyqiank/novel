<?php
/**
 * Created by PhpStorm.
 * User: qianke
 * Date: 2017/11/20 0020
 * Time: 下午 13:25
 */

namespace App\Http\Controllers\api\controllers\v1;


use App\Http\Controllers\Controller;
use App\Model\api\Collection;
use Illuminate\Support\Facades\Response;

class CollectorAPI extends Controller
{
    # 收藏
    public function collectorChange()
    {
        $token = request('token');
        $id = UserAPI::getUser($token);
        $book_id = request('book_id');
        if($id==null){
            return Response::json(['status'=>0]);
        }
        switch (request('type')){
            case 'add':
                Collection::add($id,$book_id);
                break;
            case 'del':
                Collection::del($id,$book_id);
                break;
            default:
                return Response::json(['status'=>0]);
        }
    }
    # 查询收藏
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
        $data = (new Shelf())->getBooks(array_values($data));
        return Response::json($data);

    }
}