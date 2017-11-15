<?php

namespace App\Model\api;

class PhoneCode extends BaseModel
{
    protected $table="phoneCode";
    protected $fillable = ['phone','code'];
}
