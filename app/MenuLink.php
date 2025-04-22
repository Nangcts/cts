<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuLink extends Model {

	protected $table = 'menu_link';
	protected $fillable = ['id','name','link','menu_id','menu_code','status','sort_order','parent_id'];
	public $timestamps =false;
	public function menu() {
		return $this->belongsTo('App\Menu','menu_id','id');
	}
}
