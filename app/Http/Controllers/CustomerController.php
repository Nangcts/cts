<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class CustomerController extends Controller
{
    public function showDashboard () 
    {
    	return view('customer.dashboard');
    }
}
