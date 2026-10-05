<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('arsip', 'id_timeline')) {
            Schema::table('arsip', function (Blueprint $table) {
                $table->integer('id_timeline')
                    ->nullable();
            });
        }
    }
    public function down(): void
    {
        if (Schema::hasColumn('arsip', 'id_timeline')) {
            Schema::table('arsip', function (Blueprint $table) {
                $table->dropColumn('id_timeline');
            });
        }
    }
};