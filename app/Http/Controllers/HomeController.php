<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

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
            
            $data['category_products'] = Product::addSelect(['id' => function ($query) use($data) {
                                                $query->select('product_id')
                                                        ->from('products_categories')
                                                        ->where('category_id', $data['category_info']->id)
                                                        ->orderBy('products.id', 'desc');
                                            }])->get();
            
            return view('frontend/category/category_wise_product_list', $data);
        } else {
            return view('frontend/404_page', $data);
        }
    }

}
