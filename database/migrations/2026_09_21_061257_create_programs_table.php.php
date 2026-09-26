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
    Schema::create('programs', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('division'); // Bidang Kerohanian, Olahraga, Humas, dll.
        $table->enum('status', ['Perencanaan', 'Berjalan', 'Selesai'])->default('Perencanaan');
        $table->text('description')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
