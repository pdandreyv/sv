<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'social_provider')) {
                $table->string('social_provider', 40)->nullable()->after('remember_token');
            }
            if (!Schema::hasColumn('users', 'social_id')) {
                $table->string('social_id', 191)->nullable()->after('social_provider');
            }
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar', 500)->nullable()->after('social_id');
            }
            if (!Schema::hasColumn('users', 'telegram_username')) {
                $table->string('telegram_username', 191)->nullable()->after('avatar');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'telegram_username')) {
                $table->dropColumn('telegram_username');
            }
            if (Schema::hasColumn('users', 'avatar')) {
                $table->dropColumn('avatar');
            }
            if (Schema::hasColumn('users', 'social_id')) {
                $table->dropColumn('social_id');
            }
            if (Schema::hasColumn('users', 'social_provider')) {
                $table->dropColumn('social_provider');
            }
        });
    }
};
