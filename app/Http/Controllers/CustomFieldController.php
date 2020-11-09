<?php

namespace App\Http\Controllers;

use App\Models\CustomField;
use Illuminate\Http\Request;
use Auth;
use DB;
class CustomFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['all_custom_field'] = CustomField::all();
        return view("admin.custom_field.all_custom_field", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.custom_field.add_custom_field");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'field_section' => 'required',
            'field_type' => 'required',
            'field_key' => 'required',
            'field_label' => 'required',
            'field_validation' => 'required',
            'field_in_list' => 'required',
        ]);


        $table_name = $request->field_section;
        $column_name = $request->field_key;

        if ($request->field_default_value) {

            $default_value = '"'.$request->field_default_value.'"';
            DB::statement('ALTER TABLE '.$table_name.' ADD '.$column_name.' VARCHAR(255) DEFAULT'.$default_value.'');
        }else{

            DB::statement('ALTER TABLE '.$table_name.' ADD '.$column_name.' VARCHAR(255)');
        }

        

        $field_created_by = Auth::user()->id;
        $custom_field = new CustomField;

        $custom_field->field_section = $request->field_section;
        $custom_field->field_type = $request->field_type;
        $custom_field->field_key = $request->field_key;
        $custom_field->field_label = $request->field_label;
        $custom_field->field_validation = $request->field_validation;
        $custom_field->field_in_list = $request->field_in_list;
        $custom_field->field_default_value = $request->field_default_value;
        $custom_field->field_created_by = $field_created_by;

        //echo "<pre>";print_r($custom_field);die();
        $custom_field->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CustomField  $customField
     * @return \Illuminate\Http\Response
     */
    public function show(CustomField $customField)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomField  $customField
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['custom_field'] = CustomField::find($id);

        //echo "<pre>";print_r($data['client_info']);die();

        return view("admin.custom_field.edit_custom_field",$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CustomField  $customField
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'field_section' => 'required',
            'field_type' => 'required',
            'field_key' => 'required',
            'field_label' => 'required',
            'field_validation' => 'required',
            'field_in_list' => 'required',
        ]);


        // $table_name = $request->field_section;
        // $column_name = $request->field_key;

        // if ($request->field_default_value) {

        //     $default_value = '"'.$request->field_default_value.'"';
        //     DB::statement('ALTER TABLE '.$table_name.' ADD '.$column_name.' VARCHAR(255) DEFAULT'.$default_value.'');
        // }else{

        //     DB::statement('ALTER TABLE '.$table_name.' ADD '.$column_name.' VARCHAR(255)');
        // }

        

        $custom_field = CustomField::find($id);

        $custom_field->field_section = $request->field_section;
        $custom_field->field_type = $request->field_type;
        $custom_field->field_key = $request->field_key;
        $custom_field->field_label = $request->field_label;
        $custom_field->field_validation = $request->field_validation;
        $custom_field->field_in_list = $request->field_in_list;
        $custom_field->field_default_value = $request->field_default_value;
        //echo "<pre>";print_r($custom_field);die();
        $custom_field->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CustomField  $customField
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        
        $custom_field = CustomField::find($id);
        $custom_name = $custom_field->field_key;
        $table_name = $custom_field->field_section;
        DB::statement('ALTER TABLE '.$table_name.' DROP COLUMN '.$custom_name);
        $custom_field->delete();

        return redirect('custom-fields');
    }

    public function change_status($id){
        $custom_field = CustomField::find($id);
        
        if ($custom_field->field_status == 'ACTIVE') {
            $custom_field->field_status = 'INACTIVE';
        }else{
            $custom_field->field_status = 'ACTIVE';
        }
        
        $custom_field->save();
    }
}
