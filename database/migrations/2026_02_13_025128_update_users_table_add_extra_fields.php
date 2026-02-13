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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('username')->unique()->after('id');
            $table->string('firstname')->after('username');
            $table->string('middlename')->nullable()->after('firstname');
            $table->string('lastname')->after('middlename');
            $table->string('address')->nullable()->after('lastname');
            $table->string('contact_number')->nullable()->after('address');
            $table->string('ip')->nullable()->after('password');
            $table->string('browser')->nullable()->after('ip');
            $table->decimal('credits', 10, 2)->default(0)->after('browser');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->dropColumn(['username', 'firstname', 'middlename', 'lastname', 'address', 'contact_number', 'ip', 'browser', 'credits']);
        });
    }
};
