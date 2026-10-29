
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('warta', function (Blueprint $table) {
            $table->text('lead_berita')->change();
        });
    }

    public function down(): void
    {
        Schema::table('warta', function (Blueprint $table) {
            $table->string('lead_berita', 255)->change();
        });
    }
};
