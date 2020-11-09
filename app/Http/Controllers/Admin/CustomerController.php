<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomField;
use App\Models\Type;
use App\Models\Country;
use App\Models\State;
use Auth;
use DB;

class CustomerController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if (!Auth::user()->can('view-customer')) {
            return view("not_allow");
        }

        $data['all_customer'] = Customer::all();
        return view("admin.customer.all_customer", $data);
    }

    public function customer_list(Request $request) {
        $draw = intval($request->draw);
        $start = intval($request->start);
        $limit = intval($request->length);
        $sortBy = null;
        $sortDirection = '';

        if (isset($request->order[0]['column'])) {
            $sortBy = $request->columns[$request->order[0]['column']]['data'];
            $sortDirection = $request->order[0]['dir'];
        }

        $total_data = DB::table('customers')
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

        $customer_list = DB::table('customers')
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

        foreach ($customer_list as $row) {
            $action = '';
            $status = '';
            $checked = '';

            if ($row->customer_status == 'ACTIVE') {
                $checked = 'Checked';
            }

            $status = '<div class="custom-control custom-switch text-center">';
            $status .= '<input class="custom-control-input customer_status" type="checkbox" ' . $checked . ' data-id="' . $row->id . '" id="customer' . $row->id . '">';
            $status .= '<label id="active_status_' . $row->id . '" class="custom-control-label" for="customer' . $row->id . '">' . $row->customer_status . '</label>';
            $status .= '</div>';

            $message = 'Are You Sure you wnat to delete';

            $action .= "<a class='btn btn-primary btn-sm mr-2' href='customers/" . $row->id . "'>View</a>";

            if (Auth::user()->can('edit-customer')) {
                $action .= "<a class='btn btn-success btn-sm mr-2' href='customers/" . $row->id . "/edit'>Edit</a>";
            }

            if (Auth::user()->can('delete-customer')) {
                $action .= "<form action='" . route('customers.destroy', $row->id) . "' method='POST' style='display: inline-block;'>"
                        . csrf_field() . ""
                        . method_field('DELETE') . "
                            <button class='btn btn-danger btn-sm' type='submit'>Delete</button>
                        </form>";
            }


            $customer_array['sl'] = $i;
            $customer_array['customer_name'] = $row->customer_first_name;
            $customer_array['customer_phone'] = $row->customer_phone;
            $customer_array['customer_email'] = $row->customer_email;
            $customer_array['country_name'] = $row->country_name;
            $customer_array['state_name'] = $row->state_name;
            $customer_array['customer_status'] = $status;
            $customer_array['action'] = $action;

            $data[] = $customer_array;
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
    public function create() {
        if (!Auth::user()->can('add-customer')) {
            return view("not_allow");
        }

        $data['customer_id'] = 'clt#5548564';
        $data['all_customer_custom_field'] = CustomField::where('field_section', 'customers')->where('field_status', 'ACTIVE')->get();

        $data['customer_type_section'] = Type::where('type_section', 'CUSTOMER')->get();
        $data['all_countries'] = Country::all();
        return view("admin.customer.add_customer", $data);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  Country ID
     * @return \Illuminate\Http\Response states list
     */
    public function get_states($id) {
        $states = State::where('country_id', $id)->get();
        $html = '';
        $html .= '<option value="">Select Region</option>';
        foreach ($states as $row) {
            $val = $row->id . ' | ' . $row->name;
            $html .= '<option value="' . $val . '">' . $row->name . '</option>';
        }
        return response($html);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if (!Auth::user()->can('add-customer')) {
            return view("not_allow");
        }

        $all_customer_custom_field = CustomField::where('field_section', 'customers')->where('field_status', 'ACTIVE')->get();

        //echo "<pre>";print_r($all_customer_custom_field);die();

        foreach ($all_customer_custom_field as $key => $value) {
            if ($value['field_validation'] == 'required') {
                $validationArray[$value['field_key']] = 'required';
            }
        }

        $validationArray['customer_first_name'] = 'required';
        $validationArray['country'] = 'required';
        $validationArray['state_name'] = 'required';
        $validationArray['customer_last_name'] = 'required';
        $validationArray['password'] = 'min:6|required_with:confirm_password';
        $validationArray['confirm_password'] = 'min:6|required|same:password';

//        $validationArray['customer_type'] = 'required';
        $validationArray['customer_email'] = 'required|unique:customers|email';
        $validationArray['customer_phone'] = 'required|unique:customers';


        $this->validate($request, $validationArray);
        $data['customer_first_name'] = $request->input('customer_first_name');
        $data['customer_code'] = $request->input('customer_code');
        $data['customer_last_name'] = $request->input('customer_last_name');
        $data['customer_postal_code'] = $request->input('customer_postal_code');
        $data['customer_email'] = $request->input('customer_email');
        $data['customer_phone'] = $request->input('customer_phone');
        $data['customer_address'] = $request->input('customer_address');
        $data['password'] = \Illuminate\Support\Facades\Hash::make($request->input('password'));
//        $data['customer_type'] = $request->input('customer_type');



        $data['customer_status'] = 1;
        $data['country_id'] = $request->country_id;
        $data['country_name'] = $request->country_name;
        $data['state_id'] = $request->state_id;
        $data['state_name'] = $request->state_name;

        foreach ($all_customer_custom_field as $key => $row) {
            $data[$row['field_key']] = $request->input($row['field_key']);
        }

        Customer::insert($data);
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
        if (!Auth::user()->can('edit-customer')) {
            return view("not_allow");
        }

        $data['all_customer_custom_field'] = CustomField::where('field_section', 'customers')->where('field_status', 'ACTIVE')->get();

        $data['customer_info'] = Customer::find($id);

        $data['customer_type_section'] = Type::where('type_section', 'CLIENT')->get();
        //echo "<pre>";print_r($data['customer_info']);die();
        $data['all_countries'] = Country::where('id', $data['customer_info']->country_id)->get();
        $data['all_states'] = State::where('id', $data['customer_info']->state_id)->get();
//           echo '<pre>';
//           print_r($data['all_states']);die;
        return view("admin.customer.edit_customer", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        if (!Auth::user()->can('edit-customer')) {
            return view("not_allow");
        }
        $all_customer_custom_field = CustomField::where('field_section', 'customers')->where('field_status', 'ACTIVE')->get();

        foreach ($all_customer_custom_field as $key => $value) {
            if ($value['field_validation'] == 'required') {
                $validationArray[$value['field_key']] = 'required';
            }
        }

        $validationArray['customer_first_name'] = 'required';
        $validationArray['customer_last_name'] = 'required';
        if ($request->password != null) {
            $validationArray['password'] = 'min:6|required_with:confirm_password';
            $validationArray['confirm_password'] = 'min:6|required|same:password';
        }
        $validationArray['country'] = 'required';
        $validationArray['state_name'] = 'required';
        $validationArray['customer_email'] = 'required';
        $validationArray['customer_phone'] = 'required';
//        $validationArray['customer_type'] = 'required';


        $this->validate($request, $validationArray);

        $data['customer_first_name'] = $request->input('customer_first_name');
        $data['customer_code'] = $request->input('customer_code');
        $data['customer_last_name'] = $request->input('customer_last_name');
        $data['customer_postal_code'] = $request->input('customer_postal_code');
        $data['customer_email'] = $request->input('customer_email');
        $data['customer_phone'] = $request->input('customer_phone');
        $data['customer_address'] = $request->input('customer_address');
        if ($request->password != null) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->input('password'));
        }

//        $data['customer_type'] = $request->input('customer_type');
        $data['customer_status'] = 1;
        $data['country_id'] = $request->country_id;
        $data['country_name'] = $request->country_name;
        $data['state_id'] = $request->state_id;
        $data['state_name'] = $request->state_name;

        foreach ($all_customer_custom_field as $key => $row) {
            $data[$row['field_key']] = $request->input($row['field_key']);
        }

        Customer::updateCustomerData($id, $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        if (!Auth::user()->can('delete-customer')) {
            return view("not_allow");
        }

        $customer = Customer::find($id);
        $customer->delete();
        return redirect('customers');
    }

    public function change_status($id) {
        $Customer = Customer::find($id);

        if ($Customer->customer_status == 'ACTIVE') {
            $Customer->customer_status = 'INACTIVE';
        } else {
            $Customer->customer_status = 'ACTIVE';
        }

        $Customer->save();
    }

}
