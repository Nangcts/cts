<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\MenuRequest;
use App\Menu;
use App\Menulink;

class MenuController extends Controller {
	public function showMenu($id)
	{
		$menu = Menu::find($id);
		$menu_link = MenuLink::where('menu_id', $id)->orderBy('sort_order','asc')->get();
		return view('admin.menu.menu', compact('menu','menu_link'));
	}
}
