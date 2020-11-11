<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\Vendor;
use App\Models\CustomField;
use App\Models\Country;
use App\Models\State;
use App\User;
use App\Models\Type;
use Auth;
use DB;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->can('view-vendor')) {
            return view("not_allow");
        }
        $data['all_vendors'] = Vendor::with('user')->get();

        //echo "<pre>";print_r($data['all_vendors']);die();
        return view("admin.vendor.all_vendors", $data);
    }
    
    public function vendor_list(Request $request) {
        $draw = intval($request->draw);
        $start = intval($request->start);
        $limit = intval($request->length);
        $sortBy = null;
        $sortDirection = '';
        
        if(isset($request->order[0]['column'])){
            $sortBy = $request->columns[$request->order[0]['column']]['data'];
            $sortDirection = $request->order[0]['dir'];
        }
        
        $total_data = DB::table('vendors')
                            ->when($sortBy, function ($query, $sortBy) use($sortDirection) {
                                return $query->orderBy($sortBy, $sortDirection);
                            }, function ($query) {
                                return $query->orderBy('id', 'desc');
                            })
//                            ->when($filterList, function ($query, $filterList) use ($columns) {
//                                foreach($filterList as $key => $val) {
//                                    return $query->where($columns[$key]['name'], 'like', "%".$val[0]."%");
//                                }
//                            })
                            ->count();

        $vendor_list = DB::table('vendors')
                            ->when($sortBy, function ($query, $sortBy) use($sortDirection) {
                                return $query->orderBy($sortBy, $sortDirection);
                            }, function ($query) {
                                return $query->orderBy('id', 'desc');
                            })
//                            ->when($filterList, function ($query, $filterList) use ($columns) {
//                                foreach($filterList as $key => $val) {
//                                    return $query->where($columns[$key]['name'], 'like', "%".$val[0]."%");
//                                }
//                            })
                            ->offset($start)
                            ->limit($limit)
                            ->get();

        $data = array();
        $i = 1;
                
        foreach($vendor_list as $row) {
            $action = '';
            $message = 'Are You Sure you wnat to delete';
            $action.= "<a class='btn btn-primary btn-sm mr-2' href='vendors/".$row->id."'>View</a>";

            if (Auth::user()->can('edit-vendor')) {
                $action.= "<a class='btn btn-success btn-sm mr-2' href='vendors/".$row->id."/edit'>Edit</a>";
            } 
            
            if (Auth::user()->can('delete-vendor')) {
            $action.= "<form action='".route('vendors.destroy', $row->id)."' method='POST' style='display: inline-block;'>"
                            .csrf_field().""
                            .method_field('DELETE')."
                            <button class='btn btn-danger btn-sm' type='submit'>Delete</button>
                        </form>";
            }
            
            $vendor_array['sl'] = $i;
            $vendor_array['company_name'] = $row->company_name;
            $vendor_array['vendor_name'] = $row->vendor_name;
            $vendor_array['action'] = $action;
            
            $data[] = $vendor_array;
            $i++;
        }
        
        $output = array(
                    "draw" => $draw,
                    "recordsTotal" => $total_data,
                    "recordsFiltered" => $total_data,
                    "data" => $data
                );
        echo json_encode($output);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('add-vendor')) {
            return view("not_allow");
        }

        $data['all_vendor_custom_field'] = CustomField::where('field_section', 'vendors')->where('field_status', 'ACTIVE')->get();

        $data['vendor_type_section'] = Type::where('type_section', 'VENDOR')->get();
        $data['all_countries'] = Country::all();
        return view("admin.vendor.add_vendor",$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('add-vendor')) {
            return view("not_allow");
        }
        $all_vendor_custom_field = CustomField::where('field_section', 'vendors')->where('field_status', 'ACTIVE')->get();

        foreach ($all_vendor_custom_field as $key => $value) {
            if ($value['field_validation'] == 'required') {
                $validationArray[$value['field_key']] = 'required';
            }           
        }

        $validationArray['vendor_type'] = 'required';
        $validationArray['company_name'] = 'required';
        $validationArray['vendor_name'] = 'required';
        $validationArray['vendor_email'] = 'required|unique:vendors|email';
        $validationArray['vendor_phone'] = 'required|unique:vendors';


        $validationArray['vendor_password'] = 'required|required_with:confirm_password|same:confirm_password';
        $validationArray['confirm_password'] = 'min:6';

        $this->validate($request, $validationArray);

        $data_user['name'] = $request->input('vendor_name');
        $data_user['email'] = $request->input('vendor_email');
        $data_user['password'] = Hash::make($request->input('vendor_password'));
        $user_id = User::insertGetId($data_user,'id');

        $data_user_role['user_id'] = $user_id;
        $data_user_role['role_id'] = 9;
        DB::table('users_roles')->insert($data_user_role);

        $data['user_id'] = $user_id;
        $data['vendor_type'] = $request->input('vendor_type');
        $data['company_name'] = $request->input('company_name');
        $data['vendor_name'] = $request->input('vendor_name');
        $data['vendor_email'] = $request->input('vendor_email');
        $data['vendor_phone'] = $request->input('vendor_phone');
        $data['vendor_country_id'] = $request->input('vendor_country_id');
        $data['vendor_region_id'] = $request->input('vendor_region_id');
        $data['vendor_country_name'] = $request->input('vendor_country_name');
        $data['vendor_region_name'] = $request->input('vendor_region_name');

        foreach ($all_vendor_custom_field as $key => $row) {             
            $data[$row['field_key']] = $request->input($row['field_key']); 
        }

        Vendor::insert($data);
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
        if (!Auth::user()->can('edit-vendor')) {
            return view("not_allow");
        }

        $data['all_vendor_custom_field'] = CustomField::where('field_section', 'vendors')->where('field_status', 'ACTIVE')->get();
        $data['vendor_type_section'] = Type::where('type_section', 'VENDOR')->get();
        $data['vendor_data'] = Vendor::find($id);
        $data['all_countries'] = Country::all();
        return view("admin.vendor.edit_vendor", $data);
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
        if (!Auth::user()->can('edit-vendor')) {
            return view("not_allow");
        }

        $all_vendor_custom_field = CustomField::where('field_section', 'vendors')->where('field_status', 'ACTIVE')->get();

        foreach ($all_vendor_custom_field as $key => $value) {
            if ($value['field_validation'] == 'required') {
                $validationArray[$value['field_key']] = 'required';
            }           
        }

        $validationArray['vendor_type'] = 'required';
        $validationArray['company_name'] = 'required';
        $validationArray['vendor_name'] = 'required';
        $validationArray['vendor_email'] = 'required|email';
        $validationArray['vendor_phone'] = 'required';

        if ($request->input('vendor_password')) {
            $validationArray['vendor_password'] = 'required|required_with:confirm_password|same:confirm_password';
            $validationArray['confirm_password'] = 'min:6';
        }
        

        $this->validate($request, $validationArray);
        

        $user_id = $request->input('user_id');
        $data_user['email'] = $request->input('vendor_email');
        $data_user['name'] = $request->input('vendor_name');

        if ($request->input('vendor_password')) {
            $data_user['password'] = Hash::make($request->input('vendor_password'));
        }

        Vendor::updateUserData($user_id, $data_user);

        $data['vendor_type'] = $request->input('vendor_type');
        $data['company_name'] = $request->input('company_name');
        $data['vendor_name'] = $request->input('vendor_name');
        $data['vendor_email'] = $request->input('vendor_email');
        $data['vendor_phone'] = $request->input('vendor_phone');
        $data['vendor_country_id'] = $request->input('vendor_country_id');
        $data['vendor_region_id'] = $request->input('vendor_region_id');
        foreach ($all_vendor_custom_field as $key => $row) {             
            $data[$row['field_key']] = $request->input($row['field_key']); 
        }

        Vendor::updateVendorData($id, $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Auth::user()->can('edit-vendor')) {
            return view("not_allow");
        }

        $vendor = Vendor::find($id);
        $vendor->delete();
        
        return redirect('vendors');
    }
}
