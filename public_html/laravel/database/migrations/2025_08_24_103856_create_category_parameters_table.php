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
        Schema::create('category_parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('title'); // Parametre başlığı (örn: "Metrekare", "Oda Sayısı")
            $table->enum('type', ['input', 'select']); // input: Veri Girişi, select: Selectbox (Veri Seçme)
            $table->boolean('is_required')->default(false); // Zorunlu mu?
            $table->text('options')->nullable(); // Select tipinde seçenekler (JSON format)
            $table->integer('order')->default(0); // Sıralama
            $table->boolean('status')->default(true); // Aktif/Pasif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_parameters');
    }
};
