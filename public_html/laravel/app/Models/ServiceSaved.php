<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ServiceSaved extends Model
{
    protected $fillable = ['user_id', 'service_id'];
}
