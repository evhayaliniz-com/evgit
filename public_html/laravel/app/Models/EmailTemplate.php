<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = ['key', 'subject', 'content', 'roles', 'status'];

    protected $casts = [
        'roles' => 'array',
    ];
}
