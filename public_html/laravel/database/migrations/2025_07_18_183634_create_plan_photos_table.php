<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Plan'a ait çoklu fotoğrafları tutacak tabloyu oluşturur.
     */
    public function up(): void
    {
        Schema::create('plan_photos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('plan_id')->constrained('plans')->onDelete('cascade'); // Plan ile ilişki
            $table->string('path'); // Fotoğrafın dosya yolu

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_photos');
    }
};
