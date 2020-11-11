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



