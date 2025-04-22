<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Cviebrock\EloquentSluggable\Sluggable;

class Video extends Model
{
	use \Conner\Tagging\Taggable;
	use Sluggable;
	protected $fillable = ['id','title','link'];
	public function sluggable()
	{
		return [
			'slug' => [
				'source' => ['title'],
				'unique' => true,
			]
		];
	}
}
