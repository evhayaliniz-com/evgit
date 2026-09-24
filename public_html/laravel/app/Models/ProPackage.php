<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProPackage extends Model
{
    use SoftDeletes;

    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }

    protected $fillable = ['title', 'description', 'informations', 'status'];
}
