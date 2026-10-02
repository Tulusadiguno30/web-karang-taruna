<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            // 'umum', 'edaran', atau 'ktp_kk'
            $table->string('jenis_surat'); 
            // Kepada siapa atau perihal apa
            $table->string('judul_atau_nama'); 
            // Siapa pengurus yang mencetak
            $table->string('dicetak_oleh'); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};