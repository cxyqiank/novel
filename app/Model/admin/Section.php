<?php

namespace App\Model\admin;

class Section extends BaseModel
{
    protected $fillable = ['novel_id','section_name','address'];
    public static function delAll($id)
    {
        $section = Section::where(['novel_id'=>$id])
            ->get(['address'])
            ->take(1);
        $res3 = $res4 =1;
        if(isset($section[0]['address']))
        {
            $str1 = strrchr($section[0]['address'],'/');
            $section = str_replace($str1,'',$section[0]['address']);
            $res3  = self::dropDir($section);
            $section = Section::where(['novel_id'=>$id])
                ->get(['id'])
                ->toArray();
            $section = Section::find($section[0]['id']);
            if($section) {
                $res4 = $section->delete();
            }
        }
        if($res3 && $res4){
            return true;
        }else{
            return false;
        }
    }
}
