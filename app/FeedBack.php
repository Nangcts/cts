<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedBack extends Model
{
    protected $table = 'feedback';
    protected $fillable = ['id','name','image','adress','content'];
}
