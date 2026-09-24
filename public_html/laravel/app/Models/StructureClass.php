<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StructureClass extends Model
{
    use HasFactory;

    /**
     * Mass assignment ile hangi alanlara veri girilebilir
     */
    protected $fillable = ['name'];

    /**
     * İleride planlarla ilişki kurulacaksa:
     *
     * public function plans()
     * {
     *     return $this->hasMany(Plan::class);
     * }
     */
}
