<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('warta', function (Blueprint $table) {
            $table->boolean('is_hot_news')->default(false)->after('status_naskah');
            $table->timestamp('hot_news_until')->nullable()->after('is_hot_news');

            $table->index(['is_hot_news', 'hot_news_until']);
        });
    }

    public function down(): void
    {
        Schema::table('warta', function (Blueprint $table) {
            $table->dropIndex(['is_hot_news', 'hot_news_until']);
            $table->dropColumn(['is_hot_news', 'hot_news_until']);
        });
    }
};
