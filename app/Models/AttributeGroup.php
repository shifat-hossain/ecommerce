<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeGroup extends Model
{
    protected $table = 'attributes_group';
    protected $fillable = ['attribute_group_name'];
    
    /**
    *   Get the attributes for the attributes group.
    */
    public function attributes() {
        return $this->hasMany('App\Models\Attribute');
    }
    
    public function product_attributes() {
        return $this->belongsToMany(Attribute::class, 'products_attributes');
    }
}
