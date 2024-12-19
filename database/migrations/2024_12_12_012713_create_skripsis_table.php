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
        Schema::create('skripsis', function (Blueprint $table) {
            $table->id();
            $table->string('judulskripsi'); // Judul proyek akhir
            $table->string('nama_mahasiswa'); // Nama mahasiswa yang buat
            $table->string('dosenpembimbing'); // Nama dosen pembimbing
            $table->year('tahunterbit'); // Tahun penyerahan
            $table->text('abstract'); // Abstrak atau deskripsi singkat
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skripsis');
    }
};
