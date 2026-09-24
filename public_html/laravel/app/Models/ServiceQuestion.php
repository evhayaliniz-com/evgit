<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceQuestion extends Model
{
    protected $fillable = ['question', 'answer', 'user_id', 'company_id', 'service_id'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
