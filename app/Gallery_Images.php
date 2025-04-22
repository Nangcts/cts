<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery_Images extends Model
{
	protected $table = "gallery_images";
	protected $fillable = ['gallery_id','img_name','img_sort_order'];	

    public function gallery() {
    	return $this->belongTo('App\Gallery','gallery_id','id');
    }
}
