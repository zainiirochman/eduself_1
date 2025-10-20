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
        Schema::create('history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peminjaman_id')->nullable();
            $table->unsignedBigInteger('buku_id');
            $table->unsignedBigInteger('anggota_id');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_jatuh_tempo');
            $table->timestamp('tanggal_kembali');
            $table->integer('denda')->default(0);
            $table->timestamps();
            
            // Foreign keys (tanpa cascade delete untuk peminjaman_id karena akan dihapus)
            $table->foreign('buku_id')->references('id')->on('books')->onDelete('cascade');
            // Tidak ada foreign key untuk anggota_id dan peminjaman_id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history');
    }
};
