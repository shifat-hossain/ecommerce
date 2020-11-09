<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Customer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customers';

    //public $timestamps = false;

    public static function updateCustomerData($id,$data){
    	DB::table('customers')
    	->where('id', $id)
    	->update($data);
    }
}
