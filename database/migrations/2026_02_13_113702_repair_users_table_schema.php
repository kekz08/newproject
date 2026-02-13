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
            if (Schema::hasColumn('users', 'name')) {
                $table->dropColumn('name');
            }
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->after('id');
            }
            if (!Schema::hasColumn('users', 'gender')) {
                $table->string('gender')->after('username');
            }

            $obsoleteColumns = ['firstname', 'middlename', 'lastname', 'address', 'contact_number'];
            foreach ($obsoleteColumns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }

            if (!Schema::hasColumn('users', 'ip')) {
                $table->string('ip')->nullable()->after('password');
            }
            if (!Schema::hasColumn('users', 'browser')) {
                $table->string('browser')->nullable()->after('ip');
            }
            if (!Schema::hasColumn('users', 'credits')) {
                $table->decimal('credits', 10, 2)->default(0)->after('browser');
            }
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
