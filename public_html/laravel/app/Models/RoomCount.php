<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomCount extends Model
{
    use HasFactory;

    /**
     * Mass assignment koruması için doldurulabilir alan
     */
    protected $fillable = ['label'];

    /**
     * İleride planlarla ilişki kurulacaksa:
     *
     * public function plans()
     * {
     *     return $this->hasMany(Plan::class);
     * }
     */
}
