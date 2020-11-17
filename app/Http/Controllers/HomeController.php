<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Slider;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Attribute;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $data['all_slider'] = Slider::all();
        
        return view('frontend/home_content', $data);
    }
    
    public function category_product($param) {
        $data = array();
        $data['all_brand'] = Brand::all();
        $data['category_info'] = Category::where('slug', $param)->first();
        
        if($data['category_info']) {
            
            $data['category_products'] = Product::whereIn("id", function ($query) use ($data) {
                        $query->select('product_id')
                                ->from('products_categories')
                                ->where('category_id', $data['category_info']->id);
                    })->get();
            
            $attributes = Attribute::with(['attribute_group'])->whereHas('products.categories', function($q) use ($data) {
                $q->where('category_id', $data['category_info']->id);
            })->get();
            
            $max_val = 0;
            foreach ($data['category_products'] as $row) {
                if($max_val < $row->price){
                    $max_val = $row->price;
                }
            }
            
            $attribute_array = array();
            foreach ($attributes as $attribute) {
                $attribute_array[$attribute->attribute_group->attribute_group_name][] = $attribute;
            }
            
            $data['price_max_val'] = $max_val;
            $data['products_attributes'] = $attribute_array;
            
            return view('frontend/category/category_wise_product_list', $data);
        } else {
            return view('frontend/404_page', $data);
        }
    }

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

        if (Customer::all()->last()) {
            $last_customer_info = Customer::all()->last();
            $last_id = $last_customer_info->id;
        } else {
            $last_id = 0;
        }
        
        $customer_info->customer_code = "CST-100".($last_id + 1);

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
        $customer_info->customer_status = 'ACTIVE';
        $customer_info->password = Hash::make($request->password);

        if ($customer_info->save()) {
         
         \Session::put('user_id', $customer_info->id);
         \Session::put('customer_email', $customer_info->customer_email);
          
          return $result = array("status" => "ok","message" => "ok");
        }else{
          return $result = array("status" => "ok","message" => "Registration Fail");
        } 
    }

    public function user_login()
    {
        return view('frontend/user_account/user_login'); 
    }
    
     public function company_info() {
        return company_info();
    }

    public function user_login_check(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|min:6',
        ]);   

        $login_info = Customer::where('customer_email',$request->email)->first();


        if ($login_info) {
            if(Hash::check($request->password, $login_info->password)){
                \Session::put('user_id', $login_info->id);
                \Session::put('customer_email', $login_info->customer_email);

                return $result = array("status" => "ok","message" => "ok");
            }else{
                return $result = array("status" => "not_ok","message" => "Invalid Password");
            }
        }else{
            return $result = array("status" => "not_ok","message" => "Unregisterd User");
        }
        // echo "<pre>";print_r($login_info->password);die();
    }

}
