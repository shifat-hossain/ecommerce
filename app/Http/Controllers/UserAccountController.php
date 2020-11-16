<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;
use Session;
class UserAccountController extends Controller
{

    public function __construct() {
        // $this->middleware('customer_authenticate');
        // Session::flush();
    }

    public function user_profile()
    {
        $userId = Session::get('user_id');
    	$data['customer_info'] = Customer::where('id',$userId)->get();
    	$data['order_list'] = Order::where('customer_id',$data['customer_info'][0]->id)->get();
    	//echo "<pre>";print_r($data['customer_info'][0]->id);die();
    	return view('frontend/user_account/user_profile',$data);   
    }

    public function user_profile_edit($id)
    {
        $data['customer_info'] = Customer::find($id);
        // echo "<pre>";print_r($data['customer_info']);die();
        return view('frontend/user_account/user_profile_edit',$data);   
    }

    public function user_profile_update(Request $request,$id)
    {
        $customer_info = Customer::find($id);

        $request->validate([
            'customer_first_name' => 'required',
            'customer_last_name' => 'required',
            'customer_email' => 'required|unique:customers|email',
            'customer_phone' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
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

        $customer_info->save();
    }
}
