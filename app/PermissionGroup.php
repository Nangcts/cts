<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
	protected $table = 'permission_group';
	protected $fillable = [];
	
    public function permissions () 
    {
    	return $this->hasMany('App\Permission','group_id','id');
    }
}
