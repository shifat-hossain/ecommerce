<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\CustomField;
use App\Models\Type;
use App\Models\Country;
use App\Models\State;
use Auth;
use DB;

class ClientController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if (!Auth::user()->can('view-customer')) {
            return view("not_allow");
        }

        $data['all_client'] = Client::all();
        return view("admin.client.all_clients", $data);
    }

    public function client_list(Request $request) {
        $draw = intval($request->draw);
        $start = intval($request->start);
        $limit = intval($request->length);
        $sortBy = null;
        $sortDirection = '';

        if (isset($request->order[0]['column'])) {
            $sortBy = $request->columns[$request->order[0]['column']]['data'];
            $sortDirection = $request->order[0]['dir'];
        }

        $total_data = DB::table('clients')
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

        $client_list = DB::table('clients')
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

        foreach ($client_list as $row) {
            $action = '';
            $status = '';
            $checked = '';

            if ($row->client_status == 'ACTIVE') {
                $checked = 'Checked';
            }

            $status = '<div class="custom-control custom-switch text-center">';
            $status .= '<input class="custom-control-input client_status" type="checkbox" ' . $checked . ' data-id="' . $row->id . '" id="client' . $row->id . '">';
            $status .= '<label id="active_status_' . $row->id . '" class="custom-control-label" for="client' . $row->id . '">' . $row->client_status . '</label>';
            $status .= '</div>';

            $message = 'Are You Sure you wnat to delete';

            $action .= "<a class='btn btn-primary btn-sm mr-2' href='clients/" . $row->id . "'>View</a>";

            if (Auth::user()->can('edit-customer')) {
                $action .= "<a class='btn btn-success btn-sm mr-2' href='clients/" . $row->id . "/edit'>Edit</a>";
            }

            if (Auth::user()->can('delete-customer')) {
                $action .= "<form action='" . route('clients.destroy', $row->id) . "' method='POST' style='display: inline-block;'>"
                        . csrf_field() . ""
                        . method_field('DELETE') . "
                            <button class='btn btn-danger btn-sm' type='submit'>Delete</button>
                        </form>";
            }


            $client_array['sl'] = $i;
            $client_array['client_name'] = $row->client_name;
            $client_array['client_phone'] = $row->client_phone;
            $client_array['client_email'] = $row->client_email;
            $client_array['country_name'] = $row->country_name;
            $client_array['state_name'] = $row->state_name;
            $client_array['client_status'] = $status;
            $client_array['action'] = $action;

            $data[] = $client_array;
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
        
        $data['client_id'] = 'clt#5548564';
        $data['all_client_custom_field'] = CustomField::where('field_section', 'clients')->where('field_status', 'ACTIVE')->get();

        $data['client_type_section'] = Type::where('type_section', 'CLIENT')->get();
        $data['all_countries'] = Country::all();
        return view("admin.client.add_client", $data);
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

        $all_client_custom_field = CustomField::where('field_section', 'clients')->where('field_status', 'ACTIVE')->get();

        //echo "<pre>";print_r($all_client_custom_field);die();

        foreach ($all_client_custom_field as $key => $value) {
            if ($value['field_validation'] == 'required') {
                $validationArray[$value['field_key']] = 'required';
            }
        }

        $validationArray['client_name'] = 'required';
        $validationArray['client_type'] = 'required';
        $validationArray['client_email'] = 'required|unique:clients|email';
        $validationArray['client_phone'] = 'required|unique:clients';


        $this->validate($request, $validationArray);

        Client::insert($request->all());
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

        $data['all_client_custom_field'] = CustomField::where('field_section', 'clients')->where('field_status', 'ACTIVE')->get();

        $data['client_info'] = Client::find($id);

        $data['client_type_section'] = Type::where('type_section', 'CLIENT')->get();

        //echo "<pre>";print_r($data['client_info']);die();
        $data['all_countries'] = Country::all();
        $data['all_states'] = State::where('country_id',$data['client_info']->country_id)->get();
//           echo '<pre>';
//           print_r($data['all_states']);die;
        return view("admin.client.edit_client", $data);
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
        $all_client_custom_field = CustomField::where('field_section', 'clients')->where('field_status', 'ACTIVE')->get();

        foreach ($all_client_custom_field as $key => $value) {
            if ($value['field_validation'] == 'required') {
                $validationArray[$value['field_key']] = 'required';
            }
        }

        $validationArray['client_name'] = 'required';
        $validationArray['client_email'] = 'required';
        $validationArray['client_phone'] = 'required';
        $validationArray['client_type'] = 'required';


        $this->validate($request, $validationArray);

        $data['client_name'] = $request->input('client_name');
        $data['client_email'] = $request->input('client_email');
        $data['client_phone'] = $request->input('client_phone');
        $data['client_address'] = $request->input('client_address');
        $data['client_type'] = $request->input('client_type');


        $str = $request->country;
        $arr = explode('|', $str, 2);
        $data['country_id'] = $arr[0];
        $data['country_name'] = $arr[1];
        $string = $request->state;
        $array = explode('|', $string, 2);
        $data['state_id'] = $array[0];
        $data['state_name'] = $array[1];

        foreach ($all_client_custom_field as $key => $row) {
            $data[$row['field_key']] = $request->input($row['field_key']);
        }

        Client::updateClientData($id, $data);
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

        $client = Client::find($id);
        $client->delete();
        return redirect('clients');
    }

    public function change_status($id) {
        $Client = Client::find($id);

        if ($Client->client_status == 'ACTIVE') {
            $Client->client_status = 'INACTIVE';
        } else {
            $Client->client_status = 'ACTIVE';
        }

        $Client->save();
    }

}
