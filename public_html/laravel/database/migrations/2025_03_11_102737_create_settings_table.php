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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->nullable();
            $table->string('site_title')->nullable();
            $table->text('site_description')->nullable();
            $table->text('site_keywords')->nullable();

            $table->text('ticaret_sicil_no')->nullable();
            $table->text('kep_adres')->nullable();
            $table->text('mersis_no')->nullable();
            // Sosyal Medya
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('phone')->nullable();

            // Teknik
            $table->boolean('maintenance_mode')->default(false);
            $table->string('logo')->nullable();
            $table->string('mobile_logo')->nullable();
            $table->string('favicon')->nullable();

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
