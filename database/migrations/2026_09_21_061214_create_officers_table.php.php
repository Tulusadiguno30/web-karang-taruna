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
    Schema::create('officers', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('position'); // Ketua, Sekretaris, Bendahara, dll.
        $table->string('photo')->nullable();
        $table->integer('order_level')->default(1); // Urutan hierarki untuk tampilan
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
