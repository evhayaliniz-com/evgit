<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProPackageCategory extends Model
{
    protected $fillable = ['pro_package_id', 'category_id',
        'rights', 'monthly_price',
        'yearly_price', 'status'  , 'eplan_preview',
    'eplan_detail',
    'eplan_monthly_download_limit',];


    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }


    public function package()
    {
        return $this->belongsTo(ProPackage::class, 'pro_package_id');
    }


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
