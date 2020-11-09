<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Client extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'clients';

    //public $timestamps = false;

    public static function updateClientData($id,$data){
    	DB::table('clients')
    	->where('id', $id)
    	->update($data);
    }
}
