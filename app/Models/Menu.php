<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'parent_id',
        'content',
        'main_image',
        'display_order',
        'is_active',
    ];

    // Parent Menu
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    // Submenus
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }
}
