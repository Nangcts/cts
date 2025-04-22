<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Cviebrock\EloquentSluggable\Sluggable;
class Category extends Model
{
	use Sluggable;
	protected $table = 'categories';
	protected $fillable = ['name','parent_id','sort_order','image','slug'];
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => ['name'],
                'unique' => true,
            ]
        ];
    }

    public function products()
    {
        return $this->belongsToMany('App\Product')->orderBy('created_at','desc');
    }

    public function ScopeGetRootCategories ($query)
    {
        return $query->where('parent_id',0)->orderBy('sort_order','asc')->get();
    }

    public function ScopeGetChildsCategories ($query, $parent_id) 
    {
        return $query->where('parent_id', $parent_id)->orderBy('sort_order','asc');
    }
    
    public function getAllChids ($catalog_id) 
    {
        $term_check = $this->all();
        $id_arr = get_all_chid($term_check,$catalog->id);
        $id_arr =  explode(",", $id_arr);
        return $id_arr;
    }
}
