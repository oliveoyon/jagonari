<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    use HasFactory;

    // Add all fields you want to allow for mass assignment
    protected $fillable = [
        'event_id',
        'title',
        'image',
        'description',
        'display_order',
        'is_active',
    ];

    // Relationship to Event
    public function event()
    {
        return $this->belongsTo(GalleryEvent::class, 'event_id');
    }
}
