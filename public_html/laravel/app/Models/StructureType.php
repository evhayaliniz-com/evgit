<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StructureType extends Model
{
    use HasFactory;

    /**
     * Tabloda hangi alanlar toplu olarak doldurulabilir (mass assignment).
     */
    protected $fillable = ['name'];

    /**
     * Tablonun adı varsayılan olarak `structure_types` olduğundan elle belirtmeye gerek yok.
     * Ancak farklı isim verilirse burada belirtilebilir:
     *
     * protected $table = 'structure_types';
     */

    /**
     * Eğer bu yapı türü bir planla ilişkilendirilecekse
     * aşağıdaki gibi ilişki tanımlanabilir (ileride eklenecek):
     *
     * public function plans()
     * {
     *     return $this->hasMany(Plan::class);
     * }
     */
}
