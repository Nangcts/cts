<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Product;

class FilterController extends Controller
{
	public function getFilter()
	{
		return view('front.pages.filter');
	}
	public function postFilter (Request $r)
	{
		$min_price = $r->min_price;
		$max_price = $r->max_price;
		$brand = $r->brand;
		$full_url = $r->fullUrl();
		print_r($brand);
		// die();
		(isset($min_price) || isset($max_price) || isset($brand))? $url_char = "&" : $url_char = "?";
		// $brands = $r->brands;
		// $products = Product::where(function($query) use ($r) {
		// 	$max_price = $r->iptMaxPrice;
		// 	$brands = $r->brands;

		// 	if (isset($min_price) && isset($max_price)) {
		// 		if (isset($brands)) {
		// 			foreach ($brands as $brand) {
		// 				$query->orWhere('price', '>=', $min_price)
		// 				->where('price', '<=', $max_price)
		// 				->where('catalog_id',$brand);
		// 			}
		// 		}
		// 		$query->Where('price', '>=', $min_price)
		// 		->where('price', '<=', $max_price);
		// 	}
			
		// })->get();

		return view('front.pages.filter',compact('url_char'));
	}
}
