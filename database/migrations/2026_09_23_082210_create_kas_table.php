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
        Schema::create('kas', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            // Menghubungkan ke tabel 'anggotas' (nullable jika kas dari pihak luar/non-anggota)
            $table->foreignId('anggota_id')->nullable()->constrained('anggotas')->onDelete('cascade');
            $table->string('keterangan');
            $table->bigInteger('nominal');
            $table->enum('jenis', ['masuk', 'keluar']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kas');
    }
};