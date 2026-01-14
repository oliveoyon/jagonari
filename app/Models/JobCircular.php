<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCircular extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'file',
        'file_type',
        'department',
        'vacancy_count',
        'application_deadline',
        'published_date',
        'status',
    ];

    // Relationship with applications
    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }
}
