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

    if (!Schema::hasColumn('users', 'two_factor_enabled')) {
        $table->boolean('two_factor_enabled')->default(false)->after('password');
    }

    if (!Schema::hasColumn('users', 'two_factor_type')) {
        $table->string('two_factor_type')->default('authenticator');
    }

    if (!Schema::hasColumn('users', 'two_factor_secret')) {
        $table->text('two_factor_secret')->nullable();
    }

});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'two_factor_enabled',
                'two_factor_type',
                'two_factor_secret',
                'two_factor_recovery_codes',
                'two_factor_email_code',
                'two_factor_email_expires_at',
            ]);
        });
    }
};
