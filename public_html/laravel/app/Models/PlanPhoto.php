<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlanPhoto extends Model
{
    use HasFactory;

    protected $fillable = ['plan_id', 'path'];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
