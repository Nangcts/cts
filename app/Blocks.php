<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blocks extends Model
{
    protected $table =  'blocks';
    protected $fillable = ['id','title','body','updated_at'];

	public $timestamps =true;
}
