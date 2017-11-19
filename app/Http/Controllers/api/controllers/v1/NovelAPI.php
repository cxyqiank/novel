<?php
/**
 * Created by PhpStorm.
 * User: qianke
 * Date: 2017/11/19 0019
 * Time: 上午 10:35
 */

namespace App\Http\Controllers\api\controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;


class NovelAPI extends Controller
{
    public function contentRead()
    {
        $id = request('id');
        $info = \App\Model\admin\Novel::info($id);
        return Response::json($info);
    }
}