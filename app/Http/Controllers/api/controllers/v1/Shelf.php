<?php

namespace App\Http\Controllers\api\controllers\v1;

use App\Http\Controllers\Controller;
use \App\Model\api\shelf as shelfModel;
use App\Model\api\Novel;
use Illuminate\Support\Facades\Response;


class Shelf extends Controller
{
    public function shelfChange()
    {
        $token = request('token');
        $id = UserAPI::getUser($token);
        $book_id = request('book_id');
        if($id==null){
            return Response::json(['status'=>0]);
        }
        switch (request('type')){
            case 'add':
                shelfModel::add($id,$book_id);
                break;
            case 'del':
                shelfModel::del($id,$book_id);
                break;
            default:
                return Response::json(['status'=>0]);
        }
    }
    public function shelf()
    {
        $token = request('token');

        $id = UserAPI::getUser($token);
        if($id==null){
            return Response::json(['status'=>0]);
        }
        $data = shelfModel::where('user_id',$id)->get(['content']);

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
