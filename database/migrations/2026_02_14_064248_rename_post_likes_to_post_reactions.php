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
        Schema::rename('post_likes', 'post_reactions');
        Schema::table('post_reactions', function (Blueprint $table) {
            $table->string('type')->default('like')->after('post_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post_reactions', function (Blueprint $table) {
            $table->dropColumn('type');
        });
        Schema::rename('post_reactions', 'post_likes');
    }
};
