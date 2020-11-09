<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\AttributeGroup;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class AttributeController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['all_attributes'] = AttributeGroup::with('attributes')->get(); //      
        return view("admin.attribute.all_attribute", $data);
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
        if ($request->attribute_type == 'attribute_group') {
            $request->validate([
                "attribute_group_name" => 'required|unique:attributes_group'
            ]);

            $attribute_group = new AttributeGroup();
            $attribute_group->attribute_group_name = $request->attribute_group_name;

            $attribute_group->save();
        }

        if ($request->attribute_type == 'attribute_value') {
            $request->validate([
                "attribute_group_id" => 'required',
                "attribute_name" => 'required|unique:attributes'
            ]);
            
            $attribute = new Attribute();
            $group_name = AttributeGroup::find($request->attribute_group_id);
            if ($group_name->attribute_group_name == 'Color') {
                $attribute->color_code = $request->color_code;
            }
            $attribute->attribute_group_id = $request->attribute_group_id;
            $attribute->attribute_name = ucfirst($request->attribute_name);

            $attribute->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $data['all_attributes_group'] = AttributeGroup::all();
        $data['all_attributes'] = AttributeGroup::with('attributes')->where('id', $id)->get();
//        echo '<pre>';print_r($data['all_attributes'][0]->attribute_group_name);die;
        return view("admin.attribute.attribute_detail", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data['attribute_data'] = Attribute::find($id);
        $data['attribute_group_data'] = AttributeGroup::find($data['attribute_data']->attribute_group_id);
        return view("admin.attribute.attribute_detail_edit_form", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        if ($request->attribute_type == 'attribute_group') {
            $request->validate([
                "attribute_group_name" => 'required|unique:attributes_group,attribute_group_name,' . $id,
            ]);
            $attributeGroup = AttributeGroup::find($id);
            $attributeGroup->attribute_group_name = $request->attribute_group_name;
            $attributeGroup->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        AttributeGroup::find($id)->delete();
        return redirect('attributes');
    }

    public function fetch_attribute_group($id) {
        $attribute_data = AttributeGroup::find($id);
        echo json_encode($attribute_data);
    }

    public function delete_attribute($id) {
        $attribute = Attribute::find($id);
        $attribute->delete();
        return redirect('attributes/' . $attribute->attribute_group_id . '');
    }

    public function attributes_update(Request $request, $id) {
        $attribute = Attribute::find($id);
        $request->validate([
            "attribute_name" => 'required|unique:attributes,attribute_name,' . $id
        ]);

        $group_name = AttributeGroup::find($attribute->attribute_group_id);
        if ($group_name->attribute_group_name == 'Color') {
            $attribute->color_code = $request->attribute_color_code;
        }
        $attribute->attribute_name = ucfirst($request->attribute_name);
        $attribute->save();
    }
    
    public function summurnote_image_upload(Request $request)
    {
     
        $path = $request->file('file')->store('summernote');
        return url('/').'/storage/app/'.$path;
    }

}
