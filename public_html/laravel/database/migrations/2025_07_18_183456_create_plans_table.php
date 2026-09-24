<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * E-plan tablosunu oluşturur.
     */
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();

            // İlişkili parametreler
            $table->foreignId('structure_type_id')->constrained('structure_types')->onDelete('cascade');
            $table->foreignId('structure_class_id')->constrained('structure_classes')->onDelete('cascade');
            $table->foreignId('room_count_id')->constrained('room_counts')->onDelete('cascade');

            // Temel içerik
            $table->string('title');       // Plan başlığı
            $table->text('description');   // Plan açıklaması
            $table->string('net_area');    // Metrekare
            $table->string('gross_area');  // Brüt metrekare

            // Dosya ve durum
            $table->string('file_path')->nullable(); // rar veya pdf olabilir
            $table->boolean('status')->default(1);   // Yayında mı değil mi

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
