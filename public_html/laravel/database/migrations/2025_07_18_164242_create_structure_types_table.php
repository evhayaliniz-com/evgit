<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Yapı türlerini tutacak tabloyu oluşturur.
     * Örnek: Villa, Apartman, Daire, Müstakil Ev, vb.
     */
    public function up(): void
    {
        Schema::create('structure_types', function (Blueprint $table) {
            $table->id(); // Otomatik artan ID (primary key)
            $table->string('name'); // Yapı türü adı (örnek: Daire)
            $table->timestamps(); // created_at ve updated_at alanları
        });
    }

    /**
     * Geri alma işlemi (rollback) yapılırsa tabloyu siler.
     */
    public function down(): void
    {
        Schema::dropIfExists('structure_types');
    }
};
