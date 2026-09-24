<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Oda sayısı tablosunu oluşturur.
     * Örnek veri: 1+1, 2+1, 3+1, 4+2 gibi
     */
    public function up(): void
    {
        Schema::create('room_counts', function (Blueprint $table) {
            $table->id(); // Otomatik artan birincil anahtar
            $table->string('label'); // Oda sayısı etiketi
            $table->timestamps(); // created_at ve updated_at
        });
    }

    /**
     * Geri alma işlemi (rollback) yapılırsa tabloyu siler.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_counts');
    }
};
