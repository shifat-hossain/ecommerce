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
Route::get('/{any}', 'HomeController@category_product')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('user/registration', 'UserAccountController@user_registration');
Route::post('user/store-registration', 'UserAccountController@store_registration');


Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');

//    Vendors
    Route::post('vendor-list', 'Admin\VendorController@vendor_list');
    Route::resource('vendors', 'Admin\VendorController');

//    Role & Permission
    Route::resource('roles', 'Admin\RoleController');
    Route::resource('permissions', 'Admin\PermissionController');

//    Users
    Route::post('user-list', 'Admin\UserController@user_list');
    Route::resource('users', 'Admin\UserController');

//    Customers
    Route::resource('customers', 'Admin\CustomerController');
    Route::post('customer-list', 'Admin\CustomerController@customer_list');
    Route::post('change-customer-status/{id}', 'Admin\CustomerController@change_status');

//    Custom Field
    Route::resource('custom-fields', 'Admin\CustomFieldController');
    Route::post('change-fields-status/{id}', 'Admin\CustomFieldController@change_status');

//    Customer
    Route::resource('categories', 'Admin\CategoryController');

//    Brand
    Route::resource('brands', 'Admin\BrandController');

//    Sliders
    Route::resource('sliders', 'Admin\SliderController');

//    Attributes
    Route::resource('attributes', 'Admin\AttributeController');

    //Get Attribute Group By Id
    Route::post('fetch-attribute-group/{any}', 'Admin\AttributeController@fetch_attribute_group');

    //Delete Attribute  By Id
    Route::delete('delete-attribute/{any}', 'Admin\AttributeController@delete_attribute');

    //update Attribute By Id
    Route::post('attributes-update/{any}', 'Admin\AttributeController@attributes_update');

    //Upload Summernote Image
    Route::post('summurnote-image-upload', 'Admin\AttributeController@summurnote_image_upload')->middleware('auth');

//products
    Route::resource('products', 'Admin\ProductController')->middleware('auth');
    Route::post('products/upload', 'Admin\ProductController@upload')->name('products.upload');

//Types
    Route::resource('types', 'Admin\TypeController');

//    Units
    Route::resource('units', 'Admin\UnitController');

//    Company
    Route::get('company', 'Admin\AdminController@index');
    Route::post('edit-company-data', 'Admin\AdminController@edit_company_data');
});

Route::get('get-states/{any}', 'Admin\CustomerController@get_states');



