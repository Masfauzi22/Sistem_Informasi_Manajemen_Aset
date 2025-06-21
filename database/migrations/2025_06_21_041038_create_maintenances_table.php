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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();

            // Kolom untuk menghubungkan ke aset yang dirawat
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            
            // Detail perawatan
            $table->date('maintenance_date'); // Tanggal perawatan dilakukan
            $table->string('type'); // Tipe: 'Perbaikan', 'Servis Rutin', 'Pengecekan'
            $table->text('description'); // Deskripsi pekerjaan yang dilakukan
            $table->unsignedInteger('cost')->nullable(); // Biaya perawatan (opsional)
            $table->date('next_maintenance_date')->nullable(); // Jadwal perawatan berikutnya (opsional)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};