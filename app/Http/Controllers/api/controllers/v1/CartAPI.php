<?php


namespace App\Http\Controllers\api\controllers\v1;



use App\Http\Controllers\Controller;
use App\Model\api\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;


class CartAPI extends Controller
{
    public function index()
    {
        /*$sql = "SELECT cart_id,count(novel_id) num,c.name,c.desc FROM novel_carts nc
LEFT JOIN carts c  ON c.id = nc.cart_id
GROUP BY cart_id";
        $data = DB::select($sql);*/
        $data = Cart::withCount('novelCart')->groupBy('id')->get(['name','desc']);
        return Response::json($data);
    }
}