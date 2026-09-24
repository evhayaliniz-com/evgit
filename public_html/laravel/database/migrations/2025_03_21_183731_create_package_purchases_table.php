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
        Schema::create('package_purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id'); // Firma id
            $table->unsignedBigInteger('pro_package_id'); // Paket id
            $table->unsignedMediumInteger('used_rights'); // Kullanılan haklar
            $table->unsignedMediumInteger('remaining_rights'); // Kalan haklar
            $table->unsignedMediumInteger('total_rights'); // Toplam hak
            $table->enum('type', ['monthly', 'yearly']); // Paket türü (aylık, yıllık)
            $table->unsignedMediumInteger('duration'); // Paket Süresi (ay olarak tutuluyor)
            $table->boolean('status')->default(1); // Durum
            $table->timestamp('start_date')->nullable(); // Başlangıç tarihi
            $table->timestamp('end_date')->nullable(); // Bitiş tarihi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_purchases');
    }
};
