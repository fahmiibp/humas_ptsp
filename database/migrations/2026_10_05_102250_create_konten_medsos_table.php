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
        Schema::create('konten_medsos', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->time('jam_tayang');
            $table->string('judul');
            $table->text('caption')
            ->nullable();
            $table->string('platform');
            $table->string('status');
            $table->string('agenda_id');
            $table->string('gambar');
            $table->string('hastag');
            $table->string('format');
            $table->text('link')
            ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konten_medsos');
    }
};
