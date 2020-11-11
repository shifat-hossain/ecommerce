<?php
namespace App\Http\Traits;

use App\Models\Category;

trait CommonTrait {

    public function get_all_category() {
        $all_category = Category::whereNull('parent_id')->get();
        return $all_category;
    }
}