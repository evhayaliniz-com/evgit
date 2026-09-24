<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    protected $fillable = ['cover_photo', 'title', 'slug', 'description', 'price', 'category_id',
        'sub_category_id', 'sqm', 'rooms', 'province_id', 'district_id', 'company_id', 'video_link', 'status', 'is_confirmed'];


    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }

    public function scopeConfirmed(Builder $query): void
    {
        $query->where('is_confirmed', 1);
    }

    public function company() {
        return $this->belongsTo(Company::class,'company_id');
    }

//    public function subCategories() {
//        return $this->hasMany(ServiceCategory::class,'service_id');
//    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(Category::class, 'sub_category_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class,'district_id');
    }

    public function photos()
    {
        return $this->hasMany(ServiceImage::class,'service_id');
    }

    public function questions()
    {
        return $this->hasMany(ServiceQuestion::class, 'service_id');
    }

    public function viewCount()
    {
        return \App\Models\View::where('to_id', auth()->user()->id)->where('type', 'service')->count();
    }

    public function serviceViewCount($id)
    {
        return \App\Models\View::where('to_id', $id)->where('type', 'service')->count();
    }

    public function oldPrices()
    {
        return $this->hasMany(OldPrice::class, 'service_id');
    }

    public function parameterValues()
    {
        return $this->hasMany(ServiceParameterValue::class);
    }

    public function views()
    {
        return $this->hasMany(View::class, 'to_id')->where('type', 'service');
    }

    public function savedServices()
    {
        return $this->hasMany(ServiceSaved::class, 'service_id');
    }
}
