<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'tagline',
        'hero_eyebrow',
        'hero_title',
        'hero_copy',
        'altitude_label',
        'altitude_value',
        'velocity_label',
        'velocity_value',
        'heading_label',
        'heading_value',
        'primary_cta_label',
        'primary_cta_url',
        'secondary_cta_label',
        'secondary_cta_anchor',
        'footer_text',
    ];
}
