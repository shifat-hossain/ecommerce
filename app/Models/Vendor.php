<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Vendor extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vendors';

    public $timestamps = false;

    public function user(){
        return $this->belongsTo('App\User');
    }

    public static function updateVendorData($id,$data){
    	DB::table('vendors')
    	->where('id', $id)
    	->update($data);
    }

    public static function updateUserData($id,$data){
        DB::table('users')
        ->where('id', $id)
        ->update($data);
    }


}
