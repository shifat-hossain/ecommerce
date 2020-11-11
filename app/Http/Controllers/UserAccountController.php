<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
class UserAccountController extends Controller
{
    public function user_registration()
    {
    	return view('frontend/user_account/user_registration');    	
    }

    public function store_registration(Request $request)
    {
        $customer_info = New Customer;

        $request->validate([
            'customer_first_name' => 'required',
            'customer_last_name' => 'required',
            'customer_email' => 'required|unique:customers|email',
            'customer_phone' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'password' => 'required|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:6',
        ]);

        $customer_info->customer_first_name = $request->customer_first_name;
        $customer_info->customer_last_name = $request->customer_last_name;
        $customer_info->customer_email = $request->customer_email;
        $customer_info->customer_phone = $request->customer_phone;
        $customer_info->country_id = $request->country_id;
        $customer_info->country_name = $request->country_name;
        $customer_info->state_id = $request->state_id;
        $customer_info->state_name = $request->state_name;
        $customer_info->customer_postal_code = $request->customer_postal_code;
        $customer_info->customer_address = $request->customer_address;
        $customer_info->customer_code = '1';
        $customer_info->customer_status = 'INACTIVE';
        $customer_info->password = Hash::make($request->password);
        $customer_info->save();
    	// echo "<pre>";print_r($customer_info);die();
    }

    public function get_states($id) {
       
        return get_state();
    }
}
