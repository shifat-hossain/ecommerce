<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class BrandController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $brands = Brand::all();
        return view('admin.brand.all_brand', ['brands' => $brands]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $brand = new Brand;

        $request->validate([
            'brand_name' => 'required|unique:brands|max:255',
            'brand_image' => 'required|file|image|mimes:jpeg,png,gif,webp|max:2048'
        ]);

        $brand->brand_name = $request->brand_name;
//        $path = $request->file('brand_image')->store('avatars');
        $path = Storage::putFile('brands', $request->file('brand_image'));
        $brand->brand_image = $path;

        $brand->save();
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
        $data['brands'] = Brand::find($id);
        return view("admin.brand.edit_brand", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $request->validate([
            'brand_name' => 'required|max:255|unique:brands',
//            'brand_image' => 'required|file|image|mimes:jpeg,png,gif,webp|max:2048'
        ]);
        $brand = Brand::find($id);
        $brand->brand_name = $request->brand_name;

        if ($request->hasFile('brand_image')) {
            if (File::exists('storage/app/' . $brand->brand_image)) {
                File::delete('storage/app/' . $brand->brand_image);
            }
            $path = Storage::putFile('brands', $request->file('brand_image'));
            $brand->brand_image = $path;
        }
        $brand->save();
        echo json_encode("Done");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
//    $data =    Brand::find($id)->delete();
        $data = Brand::find($id);
        if (File::exists('storage/app/' . $data->brand_image)) {
            File::delete('storage/app/' . $data->brand_image);
        }
        $data->delete();
        return redirect()->action("BrandController@index");
    }

}
