<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Kolom id_timeline sudah ada.
        // Foreign key ditunda sampai tipe kolom diverifikasi.
    }

    public function down(): void
    {
        // Sengaja tidak menghapus kolom atau data yang sudah ada.
    }
};
