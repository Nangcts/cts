<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Cviebrock\EloquentSluggable\Sluggable;
class Catalog extends Model
{
    protected $table = 'catalog';
    protected $fillable = ['name','parent_id','show_index','slug','slug_base'];
	use Sluggable;
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => ['name'],
                'unique' => true,
            ]
        ];
    }

    public function product() {
    	return $this->hasMany('App\Product','catalog_id','id');
    }

     public function ScopeGetRootCatalogs ($query)
    {
        return $query->where('parent_id',0)->orderBy('sort_order','asc');
    }

    public function ScopeGetChildsCatalogs ($query, $parent_id) 
    {
        return $query->where('parent_id', $parent_id)->orderBy('sort_order','asc');
    }
    public function getAllChids ($catalog) 
    {
        $term_check = $this->all();
        $id_arr = get_all_chid($term_check,$catalog->id);
        $id_arr =  explode(",", $id_arr);
        return $id_arr;
    }


}
