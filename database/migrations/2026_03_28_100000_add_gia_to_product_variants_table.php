<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->decimal('gia_ban', 15, 2)->nullable()->after('so_luong');
            $table->decimal('gia_sale', 15, 2)->nullable()->after('gia_ban');
        });
    }

    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn(['gia_ban', 'gia_sale']);
        });
    }
};
