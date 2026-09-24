<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();         // Slider başlığı
            $table->text('description')->nullable();     // Açıklama
            $table->string('image');                     // Görsel
            $table->string('button_link')->nullable();   // Buton linki
            $table->integer('order')->default(0);        // Sıralama
            $table->boolean('status')->default(true);    // Aktif/Pasif
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
