<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = 'slider';
    protected $fillable = ['id','slider','order'];

    public function ScopeGetAllSlide ($query)
    {
    	return $this->orderBy('sort_order','asc')->get();
    }
}
