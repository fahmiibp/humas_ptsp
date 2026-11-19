<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('footer_settings', function (Blueprint $table) {
            $table->id();

            $table->string('logo')->nullable();

            $table->text('alamat')->nullable();

            $table->string('email')->nullable();

            $table->string('telepon_1')->nullable();
            $table->string('telepon_2')->nullable();

            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('youtube')->nullable();
            $table->string('whatsapp')->nullable();

            $table->text('deskripsi_sosial')->nullable();

            $table->string('copyright')->nullable();
            $table->string('dikelola_oleh')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('footer_settings');
    }
};