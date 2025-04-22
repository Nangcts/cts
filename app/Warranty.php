<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warranty extends Model
{
    protected $table = 'warranty';
    protected $fillable = ['id','customer_id','serial','product_name','price'];
    public $timestamps =true;
    public function customer()
    {
        return $this->belongsTo('App\Customer','customer_id','phone');
    }
}
