<?php

namespace App\Http\Controllers\api\controllers\v1;

use App\Http\Controllers\Controller;
use App\Model\api\Collection;
use App\Model\api\member;
use App\Model\api\Phone_code;
use App\Model\api\PhoneCode;
use App\Model\api\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Laravelsms\Sms\Facades\Sms;

class UserAPI extends Controller
{
    # 注册接口
    public function register(Request $request)
    {
        //接收提交过来的数据
        $input = $request->all();
        if(is_null($input['name'])){
            return Response::json(['status'=>0]);
        }
        $name_res = User::where('name',$input['name'])->get()->toArray();
        $phone_res = User::where('phone',$input['phone'])->get()->toArray();
        if($name_res!=[]) {
            return Response::json(['status'=>3,'data'=>$input, 'msg'=>User::where('name',$input['name'])->get()]);
        }
        if($phone_res!=[]) {
            return Response::json(['status'=>2,'data'=>$input, 'msg'=>User::where('phone',$input['phone'])->get()]);
        }
        $input['password'] = bcrypt($input['password']);
        //将数据插入表
        $tcode = Phone_code::where('phone',$input['phone'])->first();
        $tcode = $tcode['code'];
        $res2 = $tcode==$input['code'];
        if(!$res2) {
            return Response::json(['status'=>4]);
        }
        $res1 = User::create($input);
        if($res1)
        {$result['status'] = 1;}
        return Response::json($result);
    }
    # 发送验证码
    public function sendMsg(Request $request)
    {
        $smsDriver = Sms::driver();
        $mobile = $request->get('phone');
        $templateVar = ['yzm' => 'verifyCode','time'=>2];          //verifyCode表示使用程序自动生成的验证码
        $smsDriver->setTemplateVar($templateVar, true);  //替换模板变量，true表示返回键值对数组，false表示返回值数组
        $result = $smsDriver->singlesSend($mobile);
        $data['phone'] = $mobile;
        $data['code'] = $result['verifyCode'];
        Phone_code::updateOrCreate(['phone'=>$mobile],$data);
        if($result){
           return Response::json(['status'=>1]);
        }else{
           return Response::json(['status'=>0]);
        }
    }
    # 验证码验证
    public function checkCode(Request $request)
    {
        $phone = $request->get('phone');
        $code = $request->get('code');
        $tcode = Phone_code::where('phone',$phone)->get('code');
        if($code == $tcode)
        {
            return Response::json(['status'=>1]);
        }
        return Response::json(['status'=>0]);
    }
    # 登录接口
    public function login(Request $request)
    {
        //接收数据
        $input = $request->all();
        //验证数据
        if(isset($input)&&$input!=[])
        {	
	   $phone = User::where('phone', $input['name'])->get()->toArray();
	   $name = User::where('name', $input['name'])->get()->toArray();
	   $data = [];
	   if($phone!=[]) {
		$data = $phone;
	   }else if($name!=[]) {
		$data = $name;
	   }
            if($data==[]){
                return Response::json(['status'=>0]);
            }
            if(Hash::check($input['password'], $data[0]['password']))
            {
                $token = bcrypt(time().$input['name']);
                User::where('id',$data[0]['id'])->update(['remember_token'=>$token]);
                $data = ['status'=>1,
                    '_token' => $token
                    ];
                return Response::json($data);
            }
            else
            {
                $data = ['status'=>2];
                return Response::json($data);
            }
        }
        else
        {
            $data = ['status'=>3];
            return Response::json($data);
        }

    }

    public static function getUser($token)
    {
        $data = User::where('remember_token',$token)->get(['id'])
            ->toArray();

        if($data){
            return $data[0]['id'];
        }
        else{
            return false;
        }
    }

    public function getInfo()
    {
        $token = request('token');
        $user_id = self::getUser($token);
        $sql = 'SELECT nickname,qq,phone FROM user_infos 
      WHERE user_id='.$user_id.' ';
        $info = DB::select($sql);
        return Response::json($info);
    }

}
