<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'structure_type_id',
        'structure_class_id',
        'room_count_id',
        'title',
        'description',
        'net_area',
        'gross_area',
        'file_path',
        'measurement_file_path',
        'status',
    ];

    // İlişkiler
    public function structureType()
    {
        return $this->belongsTo(StructureType::class);
    }

    public function structureClass()
    {
        return $this->belongsTo(StructureClass::class);
    }

    public function roomCount()
    {
        return $this->belongsTo(RoomCount::class);
    }

    public function photos()
    {
        return $this->hasMany(PlanPhoto::class);
    }
}
