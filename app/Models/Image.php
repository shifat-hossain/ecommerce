<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'products_images';
    
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
