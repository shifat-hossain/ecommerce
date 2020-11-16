<?php

use App\Models\Category;
use Illuminate\Support\Facades\DB;

if (!function_exists('get_all_category')) {

    function get_all_category() {

     return $all_parent_category = Category::whereNull('parent_id')->get();
     
    }
}

if (!function_exists('get_all_country')) {

    function get_all_country() {

     return $all_country = DB::table('countries')->get();
    
    }
}


if (!function_exists('get_all_country_wise_state')) {

    function get_all_country_wise_state($id) {

     return $all_state = DB::table('states')->where('country_id',$id)->get();
    
    }
}


if (!function_exists('get_state')) {

    function get_state($id) {

        $states = DB::table('states')->where('country_id', $id)->get();
        $html = '';
        $html .= '<option value="">Select State</option>';
        foreach ($states as $row) {
            $val = $row->id . ' | ' . $row->name;
            $html .= '<option value="' . $val . '">' . $row->name . '</option>';
        }
        return response($html);    
    }
}
if (!function_exists('company_info')) {

    function company_info() {

      return $company_data = DB::table('company_info')->first();       
    }
}




