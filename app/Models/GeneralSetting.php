<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;

    protected $table = 'general_settings';

    protected $fillable = [
        'site_name',
        'tagline',
        'phone1',
        'phone2',
        'email1',
        'email2',
        'address',
        'footer_text',
        'google_map_url',
        'facebook_url',
        'twitter_url',
        'linkedin_url',
        'logo',
        'favicon',
    ];
}
