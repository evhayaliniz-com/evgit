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
        Schema::create('pro_packages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description', 2000)->nullable();
            $table->string('informations', 5000)->nullable(); // Paketin maddeleri
            $table->decimal('monthly_price'); // Aylık Ücret
            $table->decimal('yearly_price'); // Yıllık Ücret
            $table->unsignedInteger('rights'); // Paket hak sayısı
            $table->boolean('status')->default(1);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pro_packages');
    }
};
