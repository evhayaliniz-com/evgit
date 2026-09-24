<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    protected $table = 'user_informations';
    protected $fillable = ['name', 'avatar', 'user_id', 'category_id', 'sub_category_id', 'status'];


    // E-posta, şifre vb. ortak alanlara ulaşmak için bağlantı kuruyoruz
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(Category::class, 'sub_category_id');
    }
}
