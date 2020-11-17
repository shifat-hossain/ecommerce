<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class OrderDetail extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_details';

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
