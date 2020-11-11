<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Category;

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
        // $data['all_parent_category'] = Category::whereNull('parent_id')->get();
//        echo '<pre>';print_r($data['all_parent_category']);die;
        return view('frontend/home_content', $data);
    }
    
    public function category_product($param) {
        $data = array();
//        echo 32423;echo url()->previous();die;
        $data['category_info'] = Category::where('slug', $param)->get();
        $data['all_parent_category'] = Category::whereNull('parent_id')->get();
        
        if(count($data['category_info'])) {
            $data['category_products'] = Category::where('parent_id')->get();
            
            return view('frontend/category/category_wise_product_list', $data);
        } else {
            return view('frontend/404_page', $data);
        }
    }

}
