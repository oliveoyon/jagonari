<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSlider extends Model
{
    protected $fillable = [
        'title',
        'short_description',
        'long_description',
        'image',
        'display_order',
        'is_active',
    ];
}
