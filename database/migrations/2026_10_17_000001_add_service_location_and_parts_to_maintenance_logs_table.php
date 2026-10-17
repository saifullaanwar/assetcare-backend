<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('maintenance_logs', function (Blueprint $table) {
            // Lokasi servis dilakukan (bisa berbeda dari lokasi aset)
            $table->string('service_location')->nullable()->after('performed_by');
            // Rincian sparepart / komponen yang diganti
            $table->text('parts_replaced')->nullable()->after('service_location');
        });
    }

    public function down(): void
    {
        Schema::table('maintenance_logs', function (Blueprint $table) {
            $table->dropColumn(['service_location', 'parts_replaced']);
        });
    }
};
