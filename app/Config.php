<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'config';
    protected $fillable = ['id','site_title','site_des','site_keywords','site_logo','info','hotline','phone'];
   
}
