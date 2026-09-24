<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaytrLog extends Model
{
    protected $fillable = [
        'type',
        'request_data',
        'response_data',
        'merchant_oid',
        'status',
        'error_message'
    ];

    protected $casts = [
        'request_data' => 'array',
        'response_data' => 'array',
    ];
}
