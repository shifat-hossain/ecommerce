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
//Route::get('/{any}', 'HomeController@category_product')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('user/registration', 'UserAccountController@user_registration');
Route::post('user/store-registration', 'UserAccountController@store_registration');


Route::group(['prefix' => 'admin',  'middleware' => 'auth'], function() {
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');
    
    Route::post('vendor-list', 'Admin\VendorController@vendor_list');
    Route::resource('vendors', 'Admin\VendorController');
    
    Route::resource('roles', 'Admin\RoleController');
    Route::resource('permissions', 'Admin\PermissionController');
    
    Route::post('user-list', 'Admin\UserController@user_list');
    Route::resource('users', 'Admin\UserController');
});



Route::resource('customers', 'Admin\CustomerController')->middleware('auth');
Route::post('customer-list', 'Admin\CustomerController@customer_list')->middleware('auth');
Route::post('change-customer-status/{id}', 'Admin\CustomerController@change_status')->middleware('auth');

Route::resource('custom-fields', 'Admin\CustomFieldController')->middleware('auth');
Route::post('change-fields-status/{id}', 'Admin\CustomFieldController@change_status')->middleware('auth');

Route::resource('categories', 'Admin\CategoryController')->middleware('auth');
Route::resource('brands', 'Admin\BrandController')->middleware('auth');
Route::resource('sliders', 'Admin\SliderController')->middleware('auth');
Route::resource('attributes', 'Admin\AttributeController')->middleware('auth');
Route::resource('products', 'Admin\ProductController')->middleware('auth');
Route::post('products/upload', 'Admin\ProductController@upload')->name('products.upload');

//Get Attribute Group By Id
Route::post('fetch-attribute-group/{any}', 'Admin\AttributeController@fetch_attribute_group')->middleware('auth');
//Get Attribute Group By Id
//
//Delete Attribute  By Id
Route::delete('delete-attribute/{any}', 'Admin\AttributeController@delete_attribute')->middleware('auth');
//Delete Attribute By Id
//
//update Attribute By Id
Route::post('attributes-update/{any}', 'Admin\AttributeController@attributes_update')->middleware('auth');
//Update Attribute By Id
//
//Upload Summernote Image
Route::post('summurnote-image-upload', 'Admin\AttributeController@summurnote_image_upload')->middleware('auth');
//Upload Summernote Image

Route::resource('types', 'Admin\TypeController')->middleware('auth');
Route::resource('units', 'Admin\UnitController')->middleware('auth');

//Get states by country id
Route::get('get-states/{any}','Admin\CustomerController@get_states');
//Get states by country id
Route::get('company','Admin\AdminController@index');
Route::post('edit-company-data','Admin\AdminController@edit_company_data');


