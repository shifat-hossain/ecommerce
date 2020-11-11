<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class AdminController extends Controller {

    public function index() {
        $data['company_data'] = DB::table('company_info')->where('id', 1)->get();
        return view("admin.company.company", $data);
    }

    public function edit_company_data(Request $request) {        
        $company_info = DB::table('company_info')->where('id', 1)->get();       
        $data = array();
         if ($request->hasFile('company_image')) {
            if (File::exists('storage/app/' . $company_info[0]->company_image)) {
                File::delete('storage/app/' . $company_info[0]->company_image);
            }
            $path = $request->file('company_image')->store('company');
            $data['company_image'] = $path;
        }
        $data['company_name'] = $request->company_name;
        $data['company_email'] = $request->company_email;
        $data['company_phone'] = $request->company_phone;
        $data['company_address'] = $request->company_address;
        $data['longitude'] = $request->longitude;
        $data['latitude'] = $request->latitude;
        $data['fb_link'] = $request->fb_link;
        $data['twitter_link'] = $request->twitter_link;
        $data['pinterest_link'] = $request->pinterest_link;
        $data['google_link'] = $request->google_link;
        if($company_info != null){
            DB::table('company_info')->where('id', 1)->update($data);
        }
        if($company_info == null){
            DB::table('company_info')->insert($data);
        }
                   
            
    }

}
