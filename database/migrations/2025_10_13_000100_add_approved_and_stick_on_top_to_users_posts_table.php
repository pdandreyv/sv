<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users_posts')) {
            Schema::table('users_posts', function (Blueprint $table) {
                if (!Schema::hasColumn('users_posts', 'approved')) {
                    $table->boolean('approved')->default(false)->after('stick_on_top');
                }
                if (!Schema::hasColumn('users_posts', 'stick_on_top')) {
                    $table->boolean('stick_on_top')->default(false)->after('post_content');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('users_posts')) {
            Schema::table('users_posts', function (Blueprint $table) {
                if (Schema::hasColumn('users_posts', 'approved')) {
                    $table->dropColumn('approved');
                }
                if (Schema::hasColumn('users_posts', 'stick_on_top')) {
                    $table->dropColumn('stick_on_top');
                }
            });
        }
    }
};


