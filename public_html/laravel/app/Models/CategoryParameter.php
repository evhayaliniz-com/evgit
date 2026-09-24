<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryParameter extends Model
{
    protected $fillable = [
        'category_id', 'title', 'type', 'is_required', 'options', 'order', 'status'
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'status' => 'boolean',
        'options' => 'array'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function serviceValues()
    {
        return $this->hasMany(ServiceParameterValue::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
