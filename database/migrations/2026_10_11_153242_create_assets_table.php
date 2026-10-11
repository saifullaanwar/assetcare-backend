<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            // Foreign keys ke tabel categories dan locations
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');
            
            $table->string('name');                      // Nama Aset (contoh: Laptop Dell XPS 15)
            $table->string('asset_code')->unique();      // Kode Aset (contoh: AST-ELEC-001)
            $table->string('serial_number')->nullable(); // Nomor Seri
            $table->enum('status', ['available', 'in_use', 'maintenance', 'disposed'])->default('available');
            $table->date('purchase_date')->nullable();   // Tanggal Pembelian
            $table->decimal('purchase_cost', 15, 2)->nullable(); // Harga Beli
            $table->text('notes')->nullable();           // Catatan Tambahan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};