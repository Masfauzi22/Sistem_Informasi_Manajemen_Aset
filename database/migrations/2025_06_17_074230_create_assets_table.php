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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();

            // Kolom untuk menghubungkan ke tabel 'categories'
            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            // Kolom untuk menghubungkan ke tabel 'locations'
            $table->foreignId('location_id')->constrained()->onDelete('cascade');

            $table->string('serial_number')->unique()->nullable();
            $table->date('purchase_date')->nullable();
            $table->unsignedBigInteger('purchase_price');
            $table->string('status')->default('Tersedia'); // e.g., Tersedia, Dipinjam, Rusak
            $table->string('image')->nullable(); // Untuk menyimpan path/nama file gambar
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};