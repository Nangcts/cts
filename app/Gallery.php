<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Cviebrock\EloquentSluggable\Sluggable;
class Gallery extends Model
{
	use Sluggable;
	protected $table = "gallery";
	protected $fillable = ['id','g_cate_id','g_title','slug'];	
	// SlugAble

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'g_title'
            ]
        ];
    }
    public function categallery() {
		return $this->belongTo('App\CateGallery','g_cate_id','id');
	}
	public function galleryImages() {
		return $this->hasMany('App\Gallery_Images','gallery_id','id');
	}
}
