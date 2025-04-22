<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Contact;

class ContactController extends Controller
{
    public function getList() {
    	$contact = Contact::get();
    	return view('admin.contact.list',['contact'=>$contact]);
    }
}
