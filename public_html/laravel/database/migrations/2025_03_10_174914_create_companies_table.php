<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Firma Adı
            $table->string('slug'); // Firma Url Adresi
            $table->string('authorized'); // Yetkili Adı
            $table->string('fixed_phone')->nullable(); // Sabit Telefon
            $table->string('mobile_phone')->nullable(); // Cep Telefonu
            $table->string('tax_number')->unique(); // Vergi Numarası
            $table->text('about')->nullable(); // Hakkında
            $table->string('province'); // İl
            $table->string('district'); // İlçe
            $table->text('address'); // Adres
            $table->string('lat')->nullable(); // Harita Enlem Değeri
            $table->string('lng')->nullable(); // Harita Boylam Değeri
            $table->string('avatar')->default('/default/avatar.png'); // Avatar
            $table->unsignedBigInteger('category_id')->nullable(); // kategori id
            $table->unsignedBigInteger('sub_category_id')->nullable(); // alt kategori id

            // Sosyal Medya Linkleri
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('website')->nullable();

            $table->boolean('status')->default(1);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('package_id')->nullable(); // Satın alınan paket id
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
