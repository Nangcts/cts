<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Cviebrock\EloquentSluggable\Sluggable;

class Cate extends Model
{
	use Sluggable;	
    protected $table = 'cate';
    protected $fillable = ['id','name','parent_id','sort_der','slug','slug_base'];

    public function sluggable()
    {

        return [
            'slug' => [
                'source' => ['name','slug_base'],
                'unique' => true,
            ]
        ];

    }

    public function article() {
        return $this->hasMany('App\Article','cate_id','id');
    }

}
