<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

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
            //         Start   Company Thumbnail
            $file = $request->file('company_image')->hashName();
            $resize = Image::make($request->file('company_image'))->resize(180, 35, function ($constraint) {
                        
                    })->encode('jpg');

            // Put image to storage
            Storage::put("company/company_thumbnail/{$file}", $resize->__toString());
//     End   Company Thumbnail
            $data['company_thumbnail'] = 'company/company_thumbnail/' . $file;
        }

        $data['company_name'] = $request->company_name;
        $data['company_email'] = $request->company_email;
        $data['company_phone'] = $request->company_phone;
        $data['company_address'] = $request->company_address;
        $data['company_summary'] = $request->company_summary;
        $data['longitude'] = $request->longitude;
        $data['latitude'] = $request->latitude;
        $data['facebook_link'] = $request->facebook_link;
        $data['twitter_link'] = $request->twitter_link;
        $data['pinterest_link'] = $request->pinterest_link;
        $data['google_link'] = $request->google_link;
        $data['instagram_link'] = $request->instagram_link;
        if ($company_info[0] != null) {
            DB::table('company_info')->where('id', 1)->update($data);
        }
        if ($company_info[0] == null) {
            DB::table('company_info')->insert($data);
        }
    }

}
