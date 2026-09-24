<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    protected $fillable = ['title', 'slug', 'content', 'status', 'order'];

    // Slug otomatik oluşturulsun
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            $page->slug = Str::slug($page->title);
        });

        static::updating(function ($page) {
            $page->slug = Str::slug($page->title);
        });
    }
}
