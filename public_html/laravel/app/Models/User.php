<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Follower;
use Illuminate\Database\Eloquent\Builder;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'category_id',
        'sub_category_id',
        'password',
        'status',
        'google_id',
        'last_seen'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $guarded = ['user_type'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_seen' => 'datetime',
    ];


    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }


    // bireysel kullanıcıların bilgilerine ulaşıyoruz
    public function informations()
    {
        return $this->hasOne(UserInformation::class, 'user_id');
    }


    // firmaların bilgilerine ulaşıyoruz
    public function company()
    {
        return $this->hasOne(Company::class, 'user_id');
    }

    // kullanıcının fikirlerine ulaşıyoruz
    public function ideas()
    {
        return $this->hasMany(Idea::class, 'user_id');
    }

    // Kullanıcının görünen adını döndüren metod
    public function getDisplayName()
    {
        if ($this->user_type === 'user') {
            return $this->informations->name ?? $this->name;
        } elseif ($this->user_type === 'company') {
            return $this->company->name ?? $this->name;
        }

        return $this->name;
    }


    public function following($id)
    {
        return Follower::where('user_id', auth()->user()->id)->where('to_id', $id)->first();
    }
}
