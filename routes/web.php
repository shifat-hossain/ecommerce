<?php

use Illuminate\Support\Facades\Route;

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

//Route::get('/', function () {
//    return view('welcome');
//});
// Auth::routes();

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');


Route::post('vendor-list', 'VendorController@vendor_list')->middleware('auth');
Route::resource('vendors', 'VendorController')->middleware('auth');

Route::resource('roles', 'RoleController')->middleware('auth');
Route::resource('permissions', 'PermissionController')->middleware('auth');
Route::resource('users', 'UserController')->middleware('auth');
Route::post('user-list', 'UserController@user_list')->middleware('auth');

Route::resource('clients', 'ClientController')->middleware('auth');
Route::post('client-list', 'ClientController@client_list')->middleware('auth');
Route::post('change-client-status/{id}', 'ClientController@change_status')->middleware('auth');

Route::resource('custom-fields', 'CustomFieldController')->middleware('auth');
Route::post('change-fields-status/{id}', 'CustomFieldController@change_status')->middleware('auth');

Route::resource('categories', 'CategoryController')->middleware('auth');
Route::resource('brands', 'BrandController')->middleware('auth');
Route::resource('sliders', 'SliderController')->middleware('auth');
Route::resource('attributes', 'AttributeController')->middleware('auth');
Route::resource('products', 'ProductController')->middleware('auth');
Route::post('products/upload', 'ProductController@upload')->name('products.upload');

//Get Attribute Group By Id
Route::post('fetch-attribute-group/{any}', 'AttributeController@fetch_attribute_group')->middleware('auth');
//Get Attribute Group By Id
//
//Delete Attribute  By Id
Route::delete('delete-attribute/{any}', 'AttributeController@delete_attribute')->middleware('auth');
//Delete Attribute By Id
//
//update Attribute By Id
Route::post('attributes-update/{any}', 'AttributeController@attributes_update')->middleware('auth');
//Update Attribute By Id
//
//Upload Summernote Image
Route::post('summurnote-image-upload', 'AttributeController@summurnote_image_upload')->middleware('auth');
//Upload Summernote Image

Route::resource('types', 'TypeController')->middleware('auth');
Route::resource('units', 'UnitsController')->middleware('auth');

//Get states by country id
Route::get('get-states/{any}','ClientController@get_states');
//Get states by country id


