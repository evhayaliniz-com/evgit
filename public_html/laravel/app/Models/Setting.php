<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'site_name', 'site_title', 'ticaret_sicil_no', 'kep_adres', 'mersis_no','site_description', 'site_keywords',
        'facebook', 'instagram', 'youtube', 'twitter', 'linkedin', 'tiktok',
        'whatsapp', 'phone', 'maintenance_mode', 'logo', 'mobile_logo', 'favicon',
    ];
}
