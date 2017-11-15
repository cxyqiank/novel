<?php

namespace App\Model\admin;

class Hot extends BaseModel
{
    protected $fillable = ['visitors','collectors','novel_id'];
    public $timestamps = false;
    public static function del($id)
    {
        $hot = Hot::where(['novel_id'=>$id])
            ->get(['id'])
            ->toArray();
        $hot = Hot::find($hot[0]['id']);
        return $hot->delete();
    }
}
