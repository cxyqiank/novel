<?php

namespace App\Model\admin;

class Notice extends BaseModel
{
    protected $fillable= ['id','admin_id','content'];
    public function admin()
    {
        return $this->belongsTo('App\Model\admin\admin','admin_id','id');
    }
    public static function edit($input)
    {
        unset($input['_token']);
        return Notice::where('id',$input['id'])->update($input);
    }
}
