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

        if(User::where('name',$input['name'])->get()||User::where('phone',$input['phone'])->get())
        {
            return Response::json(['status'=>2,'data'=>$input]);
        }
        $input['password'] = bcrypt($input['password']);
        //将数据插入表
        $res1 = User::create($input);
        $tcode = Phone_code::where('phone',$input['phone'])->first();
        $tcode = $tcode['code'];
        $res2 = $tcode==$input['code'];
        if($res1)
        {$result['status1'] = 1;}
        if($res2)
        {$result['status2'] = 1;}
        {$result['code'] = $tcode;}
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

            $builder = User::where('name',$input['name'])??User::where('phone',$input['name']);
            $data = $builder->get(['password','name','id']);
            if(!isset($data[0]['id'])){
                return Response::json(['status'=>0]);
            }
            if($data[0]['pwd']== Hash::check($data[0]['password'],$input['password']))
            {
                $token = bcrypt(time().$input['name']);
                User::where('id',$data[0]['id'])->update(['remember_token'=>$token]);
                $data = ['status'=>1,
                    'id'     => $data[0]['id'],
                    'name'   => $data[0]['name'],
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
            $data = ['status'=>0];
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
        $info = DB::name('user_infos')
            ->where('user_id',$user_id)
            ->get(['nickname','qq','phone'])
            ->toArray();
        return Response::json($info[0]);
    }

}
