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
        Schema::create('warta', function (Blueprint $table) {
            $table->id();
            $table->string('judul_siaran_pers');
            $table->string('slug_url');
            $table->string('lead_berita');
            $table->longText('badan_berita');
            $table->string('status_naskah');
            $table->timestamp('jadwal_tayang');
            $table->longText('catatan_koreksi');
            $table->integer('timeline_id');
            $table->integer('users_id');
            $table->json('dokumentasi_utama');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warta');
    }
};
