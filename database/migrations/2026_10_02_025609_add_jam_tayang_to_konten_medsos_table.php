<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*  Schema::table('konten_medsos', function (Blueprint $table) {
            $table->time('jam_tayang')
                ->nullable()
                ->after('tanggal');
        });*/
    }
    public function down(): void
    {
       /*  Schema::table('konten_medsos', function (Blueprint $table) {
            $table->dropColumn('jam_tayang');
        }); */
    }
};
