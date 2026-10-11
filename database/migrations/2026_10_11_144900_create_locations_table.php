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
    Schema::create('locations', function (Blueprint $table) {
        $table->id();
        $table->string('name');              // Contoh: Gudang IT, Lantai 2, Ruang Rapat
        $table->string('code')->unique();    // Contoh: GDG-IT, L2-01, RR-02
        $table->string('building')->nullable(); // Contoh: Gedung Utama, Gedung B
        $table->text('description')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
