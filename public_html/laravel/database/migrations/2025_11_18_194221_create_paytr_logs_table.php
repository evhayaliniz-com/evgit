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
        Schema::create('paytr_logs', function (Blueprint $table) {
            $table->id();
            $table->string('type')->comment('İstek tipi: token, callback, recurring vb.');
            $table->text('request_data')->nullable()->comment('Gönderilen veriler (JSON)');
            $table->text('response_data')->nullable()->comment('Dönen yanıt (JSON)');
            $table->string('merchant_oid')->nullable()->comment('Sipariş numarası');
            $table->string('status')->nullable()->comment('Durum: success, error');
            $table->text('error_message')->nullable()->comment('Hata mesajı');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paytr_logs');
    }
};
