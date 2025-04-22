<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Cviebrock\EloquentSluggable\Sluggable;
class Tour extends Model
{
	use Sluggable;
	protected $table = "tour";
	protected $fillable = ['name','cate_id','diemden_id','image','intro','slug','price','ngay_di','keywords','des','order','body'];	
	// SlugAble

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function Danhmuctour() {
    	return $this->belongsTo('App\DanhmucTour','cate_id','id');
    }
    public function Diemden() {
    	return $this->belongsTo('App\Diemden','diemden_id','id');
    }
}
