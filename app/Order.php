<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $table = 'order';
	protected $fillable = ['id','transaction_id','product_id','qty','order_amount','status',];
	public $timestamps =true;
	public function transaction() {
		return $this->belongTo('App\Transaction','transaction_id','id');
	}

	public function product() {
		return $this->belongsTo('App\Product','product_id','id');
	}
}
