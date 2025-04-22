<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public function roles ()
    {
    	return $this->belongsToMany('App\Role');
    }

    public function group ()
    {
    	return $this->belongsTo('App\PermissionGroup','group_id','id');
    }
}
