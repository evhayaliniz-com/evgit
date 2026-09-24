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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('cover_photo', 500)->nullable(); // Vitrin Fotoğrafı
            $table->string('title', 500); // Başlık
            $table->string('slug', 500)->nullable(); // Slug
            $table->text('description'); // Açıklama
            $table->decimal('price'); // Ücret
            $table->enum('payment_type', ['cash', 'card']); // Ücret
            $table->unsignedBigInteger('category_id'); // Kategori id
            $table->string('sqm'); // Metrekare
            $table->unsignedMediumInteger('rooms'); // Metrekare
            $table->unsignedBigInteger('province_id'); // İl id
            $table->unsignedBigInteger('district_id'); // İlçe id
            $table->unsignedBigInteger('company_id'); // Firma
            $table->string('video_link')->nullable(); // Video Linki
            $table->string('merchant_oid')->nullable(); // Ödeme ID
            $table->boolean('status')->default(1); // Durum
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
