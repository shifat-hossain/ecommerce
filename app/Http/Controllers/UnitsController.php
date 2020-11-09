<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Units;

class UnitsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['all_units'] = Units::all(); //      
        return view("admin.units.all_units", $data);
    }

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
        $unit = new Units;
        $request->validate([
            'unit_name' => 'required|unique:units',
            'unit_code' => 'required|unique:units'
        ]);
        $unit->unit_name = $request->unit_name;
        $unit->unit_code = $request->unit_code;
        $unit->save();
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
        $data['unit_data'] = Units::find($id);
        return view('admin.units.edit_units', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $unit_data = Units::find($id);
        $request->validate([
            'unit_name' => 'required|unique:units,unit_name,'.$id,
            'unit_code' => 'required|unique:units,unit_code,'.$id
        ]);
        $unit_data->unit_name = $request->unit_name;
        $unit_data->unit_code = $request->unit_code;
        $unit_data->save();        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Units::find($id)->delete();
        return redirect('units');
    }

}
