<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserAccountController extends Controller
{
    public function user_registration()
    {
    	return view('frontend/user_account/user_registration');    	
    }
}
