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
        Schema::create('idea_replies', function (Blueprint $table) {
            $table->id();
            $table->string('content', 3000); // Mesaj
            $table->unsignedBigInteger('idea_id'); // Fikir ID
            $table->unsignedBigInteger('user_id'); // Kullanıcı ID
            $table->unsignedBigInteger('parent_reply_id')->nullable(); // Üst yorum ID
            $table->unsignedBigInteger('quoted_reply_id')->nullable(); // Alıntılanan yorum ID
            $table->boolean('status')->default(1); // Durum
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idea_replies');
    }
};
