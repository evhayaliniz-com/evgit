<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackagePayment extends Model
{
    protected $fillable = ['company_id', 'pro_package_id', 'amount', 'payment_status'];
    
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function proPackage()
    {
        return $this->belongsTo(ProPackage::class, 'pro_package_id');
    }
}
