<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $table = 'attributes';
    protected $fillable = ['attribute_name', 'attribute_group_id'];
    
    /**
    *   Get the post that owns the comment.
    */
    public function attribute_group() {
        return $this->belongsTo('App\Models\AttributeGroup');
    }
    
    public function products() {
        return $this->belongsToMany(Product::class, 'products_attributes');
    }
}
