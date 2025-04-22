<?php
//  In ra danh sách category hàng hóa 
function formatPrice($price)
{
	return number_format($price,0,',','.');
}
function categories_tree ($data,$parent = 0,$str = "", $select=0) {
	foreach ($data as $val) {
		$id = $val->categoryId;
		$name = $val->categoryName;
		$parent_id = isset($val->parentId) ? $val->parentId : null;
		if ($parent_id == $parent) {
			if ($select !=0 && $id == $select) {
				echo "<option value = '$id' selected = 'selected'>$str $name</option>";
			} else {
				echo "<option value = '$id'>$str $name</option>";
			}
			categories_tree($data,$id,$str."|---",$select);
		}
	} 

}

function get_chid_category ($parentId, $data)
{
	$chids = [];
	foreach ($data as $key => $item) {
		if(isset($item->parentId) && $item->parentId == $parentId) {
			$chids[$key] = $item;
		}
	}
	return $chids;
}

function print_block ($id)
{
	$block = DB::table('blocks')->where('id',$id)->first();
	if (isset($block)) {
		echo '<div class = "block-wrap" style = "position: relative;">';
		echo $block->body;
		if (Auth::guard('web')->check()) {
			echo '<a style = "position: absolute; right:10px; top:-5px; z-index: 9999" class = "edit-block" href = "/admin/block/edit/' .  $id  . ' "><i class ="fa fa-pencil"></i>  Sửa </a>';
		}
		echo "</div>";
	}
}

function get_block_title ($id)
{
	$block = DB::table('blocks')->where('id',$id)->first();
	echo $block->title;
}

function get_block_img ($id)
{
	$block = DB::table('blocks')->where('id',$id)->first();
	echo '<img class = "block-img" src = "/upload/blocks/' .  $block->image  . ' ">';
}

function get_block_link ($id)
{
	$block = DB::table('blocks')->where('id',$id)->first();
	echo $block->link;
}
function convertYoutube($string) {
	return preg_replace(
		"/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
		"<iframe width=\"550\" height=\"360\" src=\"//www.youtube.com/embed/$2\" allowfullscreen></iframe>",
		$string
	);
}

function getYotubeID($video_url){

	if($video_url != ''){
		preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video_url, $match);
		return $match[1];
	}
}
function strim_intro($intro, $count) {
	$intro = strip_tags($intro);
	if (strlen($intro) > 30) {
		$intro = substr($intro,0,$count);
		$end = strripos($intro,' ');
		$intro = substr($intro,0,$end);
		$intro = $intro . ' [...]';
	}
	return $intro;
}

function isActiveRoute($route, $output = "active")
{
	if (Route::currentRouteName() == $route) {
		return $output;
	}
}

function cate_parent($data,$parent = 0,$str = "", $select=0) {
	foreach ($data as $val) {
		$id = $val->id;
		$name = $val->name;
		if ($val->parent_id == $parent) {
			if ($val->parent_id == 0) {
				if ($select !=0 && $id == $select) {
					echo "<option value = '$id' class = 'root_cate' selected = 'selected'>$str $name</option>";
				} else {
					echo "<option class = 'root_cate'  value = '$id'>$str $name</option>";
				}
			}  else {
				if ($select !=0 && $id == $select) {
					echo "<option value = '$id' selected = 'selected'>$str $name</option>";
				} else {
					echo "<option value = '$id'>$str $name</option>";
				}
			}
			
			cate_parent($data,$id,$str."|---",$select);
		}
	} 

}

function cate_parent_filter ($data,$parent = 0,$str = "",$route) {
	foreach ($data as $val) {
		$id = $val->id;
		$name = $val->name;
		if ($val->parent_id == $parent) {
			echo "<li><a href = '/admin/".$route."term/". $id ."'>$str $name</a></li>";
			cate_parent_filter($data,$id,$str."|---",$route);
		}
	} 

}

function get_all_chid ($data,$parent) {
	$array =$parent;
	foreach ($data as $val) {
		$id = $val->id;
		$name = $val->name;
		if ($val->parent_id == $parent) {
			$array .=','.get_all_chid($data,$id);
		}
	}
	return $array;
}

function getAllProductsCategory ($category_id, $pagi = 12)
{
	$term_check = \App\Category::all();
	$id_arr = get_all_chid($term_check,$category_id);
	$id_arr =  explode(",", $id_arr);
	$all_products = new \Illuminate\Database\Eloquent\Collection;
	foreach ($id_arr as $key => $value) {
		$products = \App\Category::find($value)->products()->orderby('id','desc')->get();
		$all_products = $all_products->merge($products);
	}
	$products = $all_products->paginate($pagi);
	return $products;
}



function CountProduct ($category_id)
{
	$id_arr = get_all_chid(\App\Category::all(),$category_id);
	$id_arr =  explode(",", $id_arr);
	$count = 0;
	foreach ($id_arr as $id) {
		$category_count = \App\Category::find($id)->products->count();
		$count = $count + $category_count;
	}
	return $count;
}
?>