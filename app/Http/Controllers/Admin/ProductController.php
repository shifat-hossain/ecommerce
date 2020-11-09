<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\AttributeGroup;
use Auth;
use DB;

class ProductController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['all_product'] = Product::all();
        // echo '<pre>';print_r($data['all_product']);
        return view('admin.product.all_product', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $all_category = Category::all();
        $data['all_brand'] = Brand::all();
        $data['all_unit'] = Unit::all();

        $data['all_attribute_with_group'] = AttributeGroup::with('attributes')->get();
        

        $category = array(
            'categories' => array(),
            'parent_cats' => array()
        );

        foreach ($all_category as $row) {
            $category['categories'][$row->id] = $row;
            $category['parent_cats'][$row->parent_id][] = $row->id;
        }
        
//        echo '<pre>';print_r($data['all_attribute_with_group']);die;
        $category_list = "<ul class=''><li class='form-control-label text-right main-category'>Main category</li>" . $this->buildCategory('', $category) . "</ul>";

        $data['category_list'] = $category_list;
        return view('admin.product.add_product', $data);
    }

    /**
     * Build Category List
     *
     * @param  parent_id and $category[]
     * @return Category List
     */
    public function buildCategory($parent, $category, $database_cat = '') {
        $html = "";
        if (isset($category['parent_cats'][$parent])) {
            $html .= "<ul class=''>";
//            $html .= "<li class='form-control-label text-right main-category'>Main category</li>";
            foreach ($category['parent_cats'][$parent] as $cat_id) {
//                echo '<pre>';print_r($category['categories'][$cat_id]['id']);
                if (!isset($category['parent_cats'][$cat_id])) {
                    $html .= "<li> "
                            . " <label>" .
                            '<input type="checkbox" name="category[]" value="' . $category['categories'][$cat_id]['id'] . '"> ' . $category['categories'][$cat_id]->category_name .
                            '<input type="radio" class="default-category" name="main_category" value="' . $category['categories'][$cat_id]['id'] . '"> ' . '' .
                            "</label>"
                            . "</li>";
                }
                if (isset($category['parent_cats'][$cat_id])) {
                    $html .= "<li> <label>" .
                            '<input type="checkbox" name="category[]" value="' . $category['categories'][$cat_id]['id'] . '"> ' . $category['categories'][$cat_id]->category_name .
                            '<input type="radio" class="default-category" name="main_category" value="' . $category['categories'][$cat_id]['id'] . '"> ' . '' .
                            "</label>";
                    $html .= $this->buildCategory($cat_id, $category);
                    $html .= "</li>";
                }
            }
            $html .= "</ul>";
        }
        return $html;
    }

    /**
     * Upload a newly created file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return File Path
     */
    public function upload(Request $request) {

//        echo '<pre>';print_r($request->file('file'));die;
        $upload_folder = 'products';

        $path = $request->file('file')->storeAs($upload_folder, $request->file('file')->getClientOriginalName());

        return $path;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $product = new Product;

        $request->validate([
            'name' => 'required|unique:products',
            'brand' => 'required',
            'main_category' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
            'sku' => 'required|unique:products',
        ]);
        
        $response['status'] = 'Error';

        $product->name = $request->name;
        $product->brand_id = $request->brand;
        $product->main_category = $request->main_category;
        $product->slug = $request->slug;
        $product->sku = $request->sku;
        $product->ean = $request->ean;
        $product->tags = $request->tags;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->unit = $request->unit;
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->tags = $request->tags;
        $product->created_by = Auth::user()->id;
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        $product->meta_keywords = $request->meta_keywords;
        $product->status = '0';
        if($request->status) {
            $product->status = $request->status;
        }
        
        $product->save();
        
        $data_category = array();
        if($request->category) {
            foreach ($request->category as $value) {           
                $data_category['product_id'] = $product->id;
                $data_category['category_id'] = $value;
                //$product->categories()->attach($data_category);
                DB::table('products_categories')->insert($data_category);
            }
        }
        
        $data_attribute = array();
        if($request->attribute) {
            foreach ($request->attribute as $row) {           
                $data_attribute['product_id'] = $product->id;
                $data_attribute['attribute_id'] = $row;
                //$product->attributes()->attach($data_attribute);
                DB::table('products_attributes')->insert($data_attribute);
            }
        }
        
        $data_image = array();
        $i = 0;
        if($request->images_name) {
            foreach ($request->images_name as $row) {           
                $data_image['product_id'] = $product->id;
                $data_image['images_name'] = $row;
                $data_image['is_main_image'] = 0;
                if($i == 0) {
                    $data_image['is_main_image'] = 1;
                }

                //$product->attributes()->attach($data_attribute);
                DB::table('products_images')->insert($data_image);
            }
        }
        
        if(isset($product->id)) {
            $response['status'] = 'Success';
        }
        
        echo json_encode($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data['product_data'] = Product::find($id);
        $all_category = Category::all();
        $data['all_brand'] = Brand::all();
        
        $data['all_attribute_with_group'] = AttributeGroup::with('attributes')->get();

        $category = array(
            'categories' => array(),
            'parent_cats' => array()
        );

        foreach ($all_category as $row) {
            $category['categories'][$row->id] = $row;
            $category['parent_cats'][$row->parent_id][] = $row->id;
        }
        
        $product_attibute_array = array();
        foreach ($data['product_data']->attributes as $row) {
            $product_attibute_array[] = $row->pivot->attribute_id;
        }


//        echo '<pre>';print_r($product_attibute_array);die;
        $data['product_attibute_array'] = $product_attibute_array;
        $category_list = "<ul class=''><li class='form-control-label text-right main-category'>Main category</li>" . $this->buildCategory('', $category, $data['product_data']->main_category) . "</ul>";
        $data['category_list'] = $category_list;
        
        return view('admin.product.edit_product', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $product = Product::find($id);

        $request->validate([
            'name' => 'required|unique:products,name,'. $id,
            'brand' => 'required',
            'main_category' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'sku' => 'required|unique:products,sku,'. $id,
        ]);
        
        $response['status'] = 'Error';

        $product->name = $request->name;
        $product->brand_id = $request->brand;
        $product->main_category = $request->main_category;
        $product->slug = $request->slug;
        $product->sku = $request->sku;
        $product->ean = $request->ean;
        $product->tags = $request->tags;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->tags = $request->tags;
        $product->created_by = Auth::user()->id;
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        $product->meta_keywords = $request->meta_keywords;
        $product->status = '0';
        if($request->status) {
            $product->status = $request->status;
        }
        
        $product->save();
        
        DB::table('products_categories')
                ->where('product_id', '=', $product->id)
                ->delete();
        
        $data_category = array();
        if($request->category) {
            foreach ($request->category as $value) {           
                $data_category['product_id'] = $product->id;
                $data_category['category_id'] = $value;
                //$product->categories()->attach($data_category);
                DB::table('products_categories')->insert($data_category);
            }
        }
        
        $data_attribute = array();
        
        DB::table('products_attributes')
                ->where('product_id', '=', $product->id)
                ->delete();
        
        if($request->attribute) {
            foreach ($request->attribute as $row) {           
                $data_attribute['product_id'] = $product->id;
                $data_attribute['attribute_id'] = $row;
                //$product->attributes()->attach($data_attribute);
                DB::table('products_attributes')->insert($data_attribute);
            }
        }
        
        $data_image = array();
        $i = 0;
        
        if($request->images_name) {
            foreach ($request->images_name as $row) {           
                $data_image['product_id'] = $product->id;
                $data_image['images_name'] = $row;
                $data_image['is_main_image'] = 0;
                if($i == 0) {
                    $data_image['is_main_image'] = 1;
                }

                //$product->attributes()->attach($data_attribute);
                DB::table('products_images')->insert($data_image);
            }
        }
        
        if(isset($product->id)) {
            $response['status'] = 'Success';
        }
        
        echo json_encode($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $product = Product::find($id);
        $product->delete();
        
        return redirect('products');
    }

}
