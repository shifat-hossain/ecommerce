<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class UserAccountController extends Controller
{
    public function user_registration()
    {
    	return view('frontend/user_account/user_registration');    	
    }

    public function store_registration(Request $request)
    {
        $customer_info = New Customer;

        $customer_info->customer_first_name = $request->customer_first_name;
        $customer_info->customer_first_name = $request->customer_first_name;
        $customer_info->customer_first_name = $request->customer_first_name;
        $customer_info->customer_first_name = $request->customer_first_name;
        $customer_info->customer_first_name = $request->customer_first_name;
        $customer_info->customer_first_name = $request->customer_first_name;

    	echo "<pre>";print_r($customer_info);die();
    }
}
