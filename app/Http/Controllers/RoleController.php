<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use DB;
use Auth;

class RoleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if(Auth::user()->hasRole('super-admin')){
            $data['all_roles'] = Role::all();
            return view("admin.roles.all_roles", $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->hasRole('super-admin')){
            $all_permissions = Permission::all();

            $new_array = array();

            foreach($all_permissions as $row) {
                $new_array[$row['section_name']][] = $row;
            }

            // echo '<pre>';print_r($new_array);die;

            $data['all_permissions'] = $new_array;

            return view("admin.roles.add_roles", $data);
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
        if(Auth::user()->hasRole('super-admin')){
            $request->validate([
                'name' => 'required',
            ]);

            $role = new Role;

            $role->name = $request->name;
            $role->slug = str_replace(' ', '-', strtolower($request->name));

            $role->save();

            $permissions = $request->permissions;

            $data = array();
            foreach($permissions as $row) {
                $data['role_id'] = $role->id;
                $data['permission_id'] = $row;

                DB::table('roles_permissions')->insert($data);
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->hasRole('super-admin')){
            $data['role_data'] = Role::find($id);
            $all_permissions = Permission::all();

            $new_array = array();

            foreach($all_permissions as $row) {
                $new_array[$row['section_name']][] = $row;
            }

            $role_wise_permission_array = array();
            foreach ($data['role_data']->permissions as $row) {
                $role_wise_permission_array[] = $row->pivot->permission_id;
            }

            $data['role_wise_permission_array'] = $role_wise_permission_array;
            $data['all_permissions'] = $new_array;

            return view("admin.roles.edit_roles", $data);
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

            $role = Role::find($id);

            $role->name = $request->name;
            $role->slug = str_replace(' ', '-', strtolower($request->name));

            $role->save();

            $permissions = $request->permissions;

            $data = array();

            DB::table('roles_permissions')
                    ->where('role_id', '=', $role->id)
                    ->delete();

            foreach($permissions as $row) {
                $data['role_id'] = $role->id;
                $data['permission_id'] = $row;

                DB::table('roles_permissions')->insert($data);
            }
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
