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




