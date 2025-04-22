<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Cviebrock\EloquentSluggable\Sluggable;
class Article extends Model
{
	use Sluggable;
	protected $table = 'article';
	protected $fillable = ['id','title','intro','body','cate_id','sort_order','image','updated_at', 'slug','slug_base'];

	public function sluggable()
    {

        return [
            'slug' => [
                'source' => ['title'],
                'unique' => true,
            ]
        ];

    }

    public function products ()
    {
        return $this->belongsToMany('App\Product');
    }

    public function cate() {
        return $this->belongsTo('App\Cate','cate_id','id');
    }

    public function user() {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function ScopeGetLastPost($query, $limit = 12)
    {
        return $query->orderBy('id','asc')->take($limit)->get();
    }
}
