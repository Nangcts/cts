<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_Images extends Model
{
    protected $table = 'product_images';
    protected $fillable = ['id', 'name', 'alt', 'sort_order','product_id'];

    public function Product () 
    {
    	return $this->belongsTo('App\Product','product_id', 'id');
    }
}
