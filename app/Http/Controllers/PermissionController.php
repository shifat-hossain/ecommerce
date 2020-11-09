<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use Auth;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->hasRole('super-admin')) {
            $data['all_permissions'] = Permission::all();
            return view("admin.permissions.all_permissions", $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->hasRole('super-admin')) {
            return view("admin.permissions.add_permission");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->hasRole('super-admin')) {
            $request->validate([
                'section_name'  => 'required',
                'name.*'        => 'required',
            ]);

            $permissions = $request->name;
            foreach ($permissions as $row) {
                $permission = new Permission;
                
                $permission->section_name = $request->section_name;
                $permission->name = $row;
                $permission->slug = str_replace(' ', '-', strtolower($row));
                
                $permission->save();
            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->hasRole('super-admin')) {
            $data['permission_data'] = Permission::find($id);
            return view("admin.permissions.edit_permission", $data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::user()->hasRole('super-admin')){
            $request->validate([
                'name' => 'required',
            ]);

            $permission = Permission::find($id);

            $permission->section_name = $request->section_name;
            $permission->name = $request->name;
            $permission->slug = str_replace(' ', '-', strtolower($request->name));

            $permission->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
