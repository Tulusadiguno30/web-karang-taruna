<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Buat tabel warga dulu
        Schema::create('warga_rondas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('blok_rumah');
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });

        // 2. Baru buat tabel jadwal setelahnya
        Schema::create('jadwal_rondas', function (Blueprint $table) {
            $table->id();
            $table->string('periode');
            $table->date('tanggal_ronda');
            $table->unsignedBigInteger('warga_id');
            $table->foreign('warga_id')->references('id')->on('warga_rondas')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_rondas');
        Schema::dropIfExists('warga_rondas');
    }
};