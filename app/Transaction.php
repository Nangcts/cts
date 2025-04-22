<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	protected $table = 'transaction';
	protected $fillable = [];

	public $timestamps =true;

	public function orders() {
		return $this->hasMany('App\Order','transaction_id','id');
	}

	public function user ()
	{
		return $this->belongsTo('App\User','user_id','id');
	}

	public function customer ()
    {
        return $this->belongsTo('App\Customer','customer_id','id');
    }
}
