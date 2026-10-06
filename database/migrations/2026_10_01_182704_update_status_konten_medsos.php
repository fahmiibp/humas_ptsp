<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
       /*   DB::statement("
            ALTER TABLE konten_medsos
            MODIFY status
            ENUM(
                'Draft',
                'Review',
                'Siap Tayang',
                'Published'
            )
            DEFAULT 'Draft'
        ");*/
    }

    public function down(): void
    {
        /* DB::statement("
            ALTER TABLE konten_medsos
            MODIFY status
            ENUM(
                'Draft',
                'Terjadwal',
                'Publish'
            )
            DEFAULT 'Draft'
        "); */
    }
};