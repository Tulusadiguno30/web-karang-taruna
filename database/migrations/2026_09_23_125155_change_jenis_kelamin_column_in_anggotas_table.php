<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE anggotas MODIFY jenis_kelamin ENUM('L', 'P') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE anggotas MODIFY jenis_kelamin ENUM('Laki-laki', 'Perempuan') NOT NULL");
    }
};