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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            
            // Kolom untuk menghubungkan ke tabel user dan aset
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            
            // Tanggal peminjaman dan jatuh tempo
            $table->date('loan_date');
            $table->date('due_date');
            
            // Tanggal pengembalian (bisa null jika belum dikembalikan)
            $table->date('return_date')->nullable();
            
            // Status peminjaman: 'Dipinjam', 'Dikembalikan', 'Terlambat'
            $table->string('status'); 
            
            // Catatan tambahan (opsional)
            $table->text('notes')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};