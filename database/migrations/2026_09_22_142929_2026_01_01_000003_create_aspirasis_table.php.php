<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aspirasis', function (Blueprint $table) {
            $table->id('aspirasi_id');
            $table->string('nama_pengirim');
            $table->string('kontak');
            $table->text('pesan');
            $table->enum('status', ['belum_dibaca', 'dibaca', 'sudah_ditanggapi'])->default('belum_dibaca');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aspirasis');
    }
};