<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Yapı sınıfı tablosunu oluşturur.
     * Örnek değerler: 1. Sınıf, 2. Sınıf, Lüks, Ekonomik
     */
    public function up(): void
    {
        Schema::create('structure_classes', function (Blueprint $table) {
            $table->id(); // Otomatik artan ID
            $table->string('name'); // Yapı sınıfı adı
            $table->timestamps(); // created_at ve updated_at zaman bilgileri
        });
    }

    /**
     * Geri alma işlemi (rollback) yapılırsa tabloyu siler.
     */
    public function down(): void
    {
        Schema::dropIfExists('structure_classes');
    }
};
