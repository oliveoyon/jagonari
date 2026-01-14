<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];




    // Relationship with images
    public function images()
    {
        return $this->hasMany(GalleryImage::class, 'event_id');
    }
}
