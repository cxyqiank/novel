<?php

namespace App\Model\admin;

class Banner extends BaseModel
{
    public $timestamps = false;
    protected $fillable = ['item','pic'];
    public static function updateBanner($input,$file)
    {
        $data['item'] = $input['item'];
        if($file)
        {
            //删除原文件
            if(unlink($input['pic']))
            {
                $path = 'uploads/bannerPic';
                //文件上传
                $input = BaseModel::uploadPic($input,$file,$path);
            }
            else
            {
                return back()->with('msg','服务器错误，请稍后重试');
            }
            $data['pic'] = $input['pic'];
        }
        else
        {
            $data['pic'] = $input['pic'];
        }
        $res = banner::where('id',$input['id'])->update($data);
        return $res;
    }
}