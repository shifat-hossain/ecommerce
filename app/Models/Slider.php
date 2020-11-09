<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = 'sliders';
    protected $fillable = ["slider_image", "slider_title", "slider_text", "slider_tag"];
}
