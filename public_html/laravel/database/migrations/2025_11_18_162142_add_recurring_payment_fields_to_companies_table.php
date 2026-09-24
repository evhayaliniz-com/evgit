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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('utoken')->nullable()->comment('PayTR kart saklama token');
            $table->boolean('auto_renew')->default(false)->after('utoken')->comment('Otomatik paket yenileme aktif mi');
            $table->timestamp('last_payment_date')->nullable()->after('auto_renew')->comment('Son ödeme tarihi');
            $table->integer('payment_retry_count')->default(0)->after('last_payment_date')->comment('Başarısız ödeme deneme sayısı');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['utoken', 'auto_renew', 'last_payment_date', 'payment_retry_count']);
        });
    }
};
