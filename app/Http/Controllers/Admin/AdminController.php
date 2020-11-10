<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index() { 
        $data['company_data']= DB::table('company_info')->where('id',1)->get();
        return view("admin.company.company",$data);   
    }
}
