<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use \Conner\Tagging\Taggable;
	use Sluggable;
	protected $table = "products";
	protected $fillable = ['id','catalog_id', 'category_id' ,'name','price','seo_title','intro','des','view','image','slug','code','sale_price','slug_base','loai_benh','status','body','offer','check'];	
	// SlugAble

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => ['name'],
                'unique' => true,
            ]
        ];
    }

    public function combos ()
    {
        return $this->hasMany('App\Combo','product_id','id');
    }

    public function articles ()
    {
        return $this->belongsToMany('App\Article');
    }

    public function images ()
    {
        return $this->hasMany('App\Product_Images','product_id','id');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function catalog ()
    {
        return $this->belongsTo('App\Catalog','catalog_id','id');
    }
    
    public function brand ()
    {
        return $this->belongsTo('App\Brands','brand_id','id');
    }

    public function scopeGetLastProduct ($query, $limit=12)
    {
        return $query->orderBy('created_at','desc')->take($limit);
    }

    public function scopeGetProductByCatalog ($query, $catalog_id, $limit = 12)
    {
        $id_arr = get_all_chid(\App\Catalog::all(),$catalog_id);
        $id_arr =  explode(",", $id_arr);

        return $query->whereIn('catalog_id',$id_arr)->orderBy('created_at', 'DESC')->take($limit)->get();
    }
    public function scopeGetAllProductByCatalog ($query, $catalog_id)
    {
        $id_arr = get_all_chid(\App\Category::all(),$catalog_id);
        $id_arr =  explode(",", $id_arr);

        return $query->whereIn('catalog_id',$id_arr)->orderBy('created_at', 'DESC')->get();

    }
}
