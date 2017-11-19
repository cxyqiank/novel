<?php

namespace App\Model\api;

class Phone_code extends BaseModel
{
    protected $table="phone_codes";
    protected $fillable = ['phone','code'];
}
