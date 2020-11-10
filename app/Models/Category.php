<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['category_name'];
    
    public function products() {
        return $this->belongsToMany(Product::class);
    }
    
    public function subcategory() {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
