<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_circular_id',
        'name',
        'email',
        'phone',
        'resume',
        'cover_letter',
        'status',
    ];

    // ⚡ Relationship: Each application belongs to a job circular
    public function circular()
    {
        return $this->belongsTo(JobCircular::class, 'job_circular_id');
    }
}
