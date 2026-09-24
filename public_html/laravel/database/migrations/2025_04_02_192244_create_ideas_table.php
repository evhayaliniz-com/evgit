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
        Schema::create('ideas', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Başlık
            $table->string('slug')->nullable(); // Slug
            $table->text('content'); // İçerik
            $table->string('cover_photo', 500)->nullable(); // Kapak Fotoğrafı
            $table->unsignedBigInteger('category_id')->nullable(); // Kategori ID
            $table->unsignedBigInteger('sub_category_id')->nullable(); // Alt Kategori ID
            $table->string('path', 2000)->nullable(); // Medyalar
            $table->boolean('status'); // Durum
            $table->unsignedBigInteger('user_id')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ideas');
    }
};
