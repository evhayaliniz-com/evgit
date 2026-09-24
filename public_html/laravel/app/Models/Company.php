<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Company extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'slug',
        'authorized',
        'email',
        'fixed_phone',
        'mobile_phone',
        'tax_number',
        'about',
        'province',
        'district',
        'address',
        'lat',
        'lng',
        'facebook',
        'instagram',
        'youtube',
        'website',
        'avatar',
        'category_id',
        'sub_category_id',
        'status',
        'user_id',
        'is_verified',
        'is_completed',
        'utoken',
        'auto_renew',
        'last_payment_date',
        'payment_retry_count'
    ];

    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1)->where('is_completed', 1);
    }

    // E-posta, şifre vb. ortak alanlara ulaşmak için bağlantı kuruyoruz
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function provinceInfo()
    {
        return $this->hasOne(Province::class, 'id', 'province');
    }

    public function districtInfo()
    {
        return $this->hasOne(District::class, 'id', 'district');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function subCategory()
    {
        return $this->hasOne(Category::class, 'id', 'sub_category_id');
    }

    // satın alınan paketin bilgilerini alıyoruz
    public function purchasedPackages()
    {
        return $this->hasMany(PackagePurchase::class, 'company_id')->where('status', 1);
    }


    public function ratings()
    {
        return $this->hasMany(CompanyRating::class);
    }

    public function approvedRatings()
    {
        return $this->ratings()->where('is_approved', true);
    }

    public function averageRating()
    {
        return $this->approvedRatings()->avg('rating') ?? 0;
    }

    public function totalRatings()
    {
        return $this->approvedRatings()->count();
    }

    public function userRating()
    {
        if (!auth()->check()) {
            return null;
        }

        return $this->ratings()
            ->where('user_id', auth()->id())
            ->first();
    }

    // Company modeline ekle (en son satın aldığı aktif paketi alır)
    public function latestActivePackage()
    {
        return $this->purchasedPackages()
            ->latest() // en son alınanı alıyoruz
            ->with('package') // paketi dahil et
            ->first()?->package; // direk paketi al
    }

    // Onay tarihini döndürür (şimdilik updated_at kullanıyoruz, gelecekte verified_at alanı eklenebilir)
    public function getVerificationDate()
    {
        if ($this->is_verified == 1) {
            // Eğer gelecekte verified_at alanı eklenirse: return $this->verified_at;
            return $this->updated_at;
        }
        return null;
    }
}
