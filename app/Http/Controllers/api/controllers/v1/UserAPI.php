<?php

namespace App\Http\Controllers\api\controllers\v1;

use App\Model\api\member;
use App\Model\api\PhoneCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Laravelsms\Sms\Facades\Sms;
use sms\Message;

class UserAPI extends Controller
{
    //注册接口
    public function register(Request $request)
    {
        header('Access-Control-Allow-Origin:*');
        //接收提交过来的数据
        $input = $request->all();
        $input['forget'] = md5($input['phone']);
        //将数据插入表
        member::create($input);

    }
    public function sendMsg(Request $request)
    {
        header('Access-Control-Allow-Origin:*');

        $smsDriver = Sms::driver();
        $mobile = '13716021814';
        $templateVar = ['yzm' => 'verifyCode'];          //verifyCode表示使用程序自动生成的验证码
        $smsDriver->setTemplateVar($templateVar, true);  //替换模板变量，true表示返回键值对数组，false表示返回值数组
        $result = $smsDriver->singlesSend($mobile);
        return Response::json($result);

        $result = $message->sendTemplateSMS($_POST['phone'],$data,1);
        if($result===true)
        {
            $input['phone'] = $request->all()['phone'];
            $input['code']  = $code;
            $input['send_time'] = time();
            PhoneCode::create($input);
            $data = ['status'=>'1'];
            return Response::json($data);
        }
        $data = ['status'=>'0'];
        return Response::json($data);
    }
    //登录接口
    public function login(Request $request)
    {
        header('Access-Control-Allow-Origin:*');

        //接收数据
        $input = $request->all();
        //验证数据

        if(isset($input)&&$input!=[])
        {
            $pwd = member::where('phone',$input['phone'])->get(['pwd'])->toArray();
            $nickname = member::where('phone',$input['phone'])->get(['nickname'])->toArray();
            if($pwd[0]['pwd']==md5($input['pwd']))
            {
                $data = ['status'=>'1','nickname'=>$nickname[0]['nickname']];
                return Response::json($data);
            }
            else
            {
                $data = ['status'=>'3'];
                return Response::json($data);
            }
        }
        else
        {
            $data = ['status'=>'0'];
            return Response::json($data);
        }

    }
}
