<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('officer_id')->constrained('officers')->onDelete('cascade'); // Terhubung ke data Anggota
            $table->string('month_period'); // Contoh: "Januari 2026", "Februari 2026"
            $table->decimal('amount', 12, 2)->default(0);
            $table->enum('status', ['paid', 'unpaid'])->default('unpaid');
            $table->date('payment_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_contributions');
    }
};