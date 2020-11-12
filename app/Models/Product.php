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
    
    public function product_images() {
        return $this->hasMany(Image::class);
    }
    
    public function product_main_category() {
        return $this->belongsTo(Category::class, 'main_category');
    }
    
    public function brand() {
        return $this->belongsTo(Brand::class);
    }
    
    public function scopeFindByCategorySlug($query, $categorySlug) {
        return $query->whereHas('product_main_category', function ($query) use ($categorySlug) {
                    $query->where('slug', $categorySlug);
                });
    }

}
