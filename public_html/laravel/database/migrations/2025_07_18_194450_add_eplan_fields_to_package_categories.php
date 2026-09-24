<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pro_package_categories', function (Blueprint $table) {
            $table->boolean('preview_enabled')->default(false)->comment('Ön sunum aktif mi');
            $table->boolean('detail_enabled')->default(false)->comment('Detay sunum aktif mi');
            $table->integer('monthly_download_limit')->default(0)->comment('Aylık plan indirme limiti');
        });
    }

    public function down(): void
    {
        Schema::table('pro_package_categories', function (Blueprint $table) {
            $table->dropColumn(['preview_enabled', 'detail_enabled', 'monthly_download_limit']);
        });
    }
};

