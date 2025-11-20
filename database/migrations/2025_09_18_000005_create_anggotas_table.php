<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('anggotas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('jk',['Laki-laki', 'Perempuan']);
            $table->enum('prodi',['Pend. Teknologi Informasi', 'Sistem Informasi', 'Teknik Informatika']);
            $table->string('hp');
            $table->string('email')->nullable()->comment('harus berakhiran @mhs.unesa.ac.id atau null');
            $table->string('password');
            $table->timestamps();

            $table->unique('email', 'anggotas_email_unique');
        });

        $driver = DB::getDriverName();
        try {
            if ($driver === 'mysql') {
                DB::statement("ALTER TABLE anggotas ADD CONSTRAINT chk_email_unesa CHECK (email IS NULL OR email REGEXP '^[^@]+@mhs\\\\.unesa\\\\.ac\\\\.id$')");
            } elseif ($driver === 'pgsql') {
                DB::statement("ALTER TABLE anggotas ADD CONSTRAINT chk_email_unesa CHECK (email IS NULL OR email ~ '^[^@]+@mhs\\.unesa\\.ac\\.id$')");
            } elseif ($driver === 'sqlite') {
            } else {
                DB::statement("ALTER TABLE anggotas ADD CONSTRAINT chk_email_unesa CHECK (email IS NULL OR email LIKE '%@mhs.unesa.ac.id')");
            }
        } catch (\Throwable $e) {
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();
        try {
            if ($driver === 'pgsql') {
                DB::statement('ALTER TABLE anggotas DROP CONSTRAINT IF EXISTS chk_email_unesa');
            } elseif ($driver === 'mysql') {
                DB::statement('ALTER TABLE anggotas DROP CHECK chk_email_unesa');
            } elseif ($driver === 'sqlite') {
            } else {
                DB::statement('ALTER TABLE anggotas DROP CONSTRAINT IF EXISTS chk_email_unesa');
            }
        } catch (\Throwable $e) {
        }

        Schema::dropIfExists('anggotas');
    }
};