<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id', 'order', 'status' ,'image'];

    // Alt kategorileri almak için ilişki
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Üst kategoriyi almak için ilişki
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('childrenRecursive');
    }

    public function parameters()
    {
        return $this->hasMany(CategoryParameter::class)->active()->ordered();
    }

}

