<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminEmail extends Model
{
    use HasFactory;

    protected $table = 'admin_emails';

    protected $fillable = [
        'email',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
