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
        Schema::table('warta', function (Blueprint $table) {
            $table->dropForeign(['timeline_id']);
        });

        Schema::table('warta', function (Blueprint $table) {
            $table->unsignedBigInteger('timeline_id')
                ->nullable()
                ->change();

            $table->foreign('timeline_id')
                ->references('id')
                ->on('timeline')
                ->nullOnDelete();
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
