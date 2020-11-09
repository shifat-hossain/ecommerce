<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['type_list'] = Type::all();
        return view('admin.type.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'type_name' => 'required',
            'type_section' => 'required',
        ]);

        $type = new Type;

        $type->type_name = $request->type_name;
        $type->type_section = $request->type_section;

        $type->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {      
        $data['type_info'] = Type::find($id);
        //echo "<pre>";print_r($data['subject_list']);die();
        return view('admin.type.edit_type', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $type = Type::find($id);

        $request->validate([
            'type_name' => 'required',
            'type_section' => 'required',
        ]);

        $type->type_name = $request->type_name;
        $type->type_section = $request->type_section;
    
        //echo "<pre>";print_r($type);die();
        $type->save();

        //return redirect('admin/teacher/index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = Type::find($id);
        $type->delete();
        return redirect('types');
    }
}
