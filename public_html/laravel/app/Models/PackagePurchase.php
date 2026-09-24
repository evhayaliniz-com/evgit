<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PackagePurchase extends Model
{
    protected $fillable = [
        'company_id',
        'pro_package_id',
        'category_id',
        'price',
        'used_rights',
        'remaining_rights',
        'extra_right',
        'total_rights',
        'type',
        'duration',
        'merchant_oid',
        'start_date',
        'end_date',
        'expiry_date',
        'status'
    ];

    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }

    // Satın alınan paketin ait olduğu pakete ulaşıyoruz.
    public function package()
    {
        return $this->hasOne(ProPackage::class, 'id', 'pro_package_id');
    }

    // Satın alınan paketin ait olduğu firmaya ulaşıyoruz.
    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    // Satın alınan paketin ait olduğu kategoriye ulaşıyoruz.
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
