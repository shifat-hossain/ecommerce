<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    
    public function attributes() {
        return $this->belongsToMany(Attribute::class, 'products_attributes');
    }
    
    public function categories() {
        return $this->belongsToMany(Category::class, 'products_categories');
    }

}
