<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('products__products') && !Schema::hasColumn('products__products', 'production_place')) {
            Schema::table('products__products', function (Blueprint $table) {
                $table->text('production_place')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('products__products') && Schema::hasColumn('products__products', 'production_place')) {
            Schema::table('products__products', function (Blueprint $table) {
                $table->dropColumn('production_place');
            });
        }
    }
};


