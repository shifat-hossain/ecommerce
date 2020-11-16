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
        // echo "<pre>";print_r($userId);die();
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

    public function user_logout()
    {
        Session::flush();
        return redirect('user/login');
    }


    public function user_change_password(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:6',
        ]);
        
        // $data['password'] = $request->password;
        $customer_info = Customer::find($request->c_id);
        
        if(Hash::check($request->old_password, $customer_info->password)){
            // DB::table('customers')
            // ->where('id', $request->c_id)
            // ->update($data);
            // echo "<pre>";print_r($request->password);die();
            $customer_info->password = Hash::Make($request->password);
            $customer_info->save();

            return $result = array("status" => "ok","message" => "Password Change Successfully");
        }else{
            return $result = array("status" => "not_ok","message" => "Invalid Old Password");
        }
       
    }
}
