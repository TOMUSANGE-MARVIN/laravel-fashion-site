<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add new columns first
        if (!Schema::hasColumn('products', 'images')) {
            Schema::table('products', function (Blueprint $table) {
                $table->json('images')->nullable()->after('brand_id');
            });
        }

        if (!Schema::hasColumn('products', 'price')) {
            Schema::table('products', function (Blueprint $table) {
                $table->decimal('price', 15, 4)->default(0)->after('brand_id');
            });
        }

        if (!Schema::hasColumn('product_skus', 'images')) {
            Schema::table('product_skus', function (Blueprint $table) {
                $table->json('images')->nullable()->after('product_id');
            });
        }

        // For SQLite, instead of dropping columns (which is problematic),
        // we'll just leave the old columns and ignore them in the application
        // This is safer and avoids the table recreation issues
        
        // If you absolutely need to remove the columns, you can do it manually
        // after the migration or create a separate maintenance script
        
        // Optional: Set the old columns to NULL to indicate they're deprecated
        $columnsToDeprecate = ['product_image_id', 'product_video_id', 'product_sku_id'];
        
        foreach ($columnsToDeprecate as $column) {
            if (Schema::hasColumn('products', $column)) {
                DB::table('products')->update([$column => null]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void 
    {
        // Remove added columns
        if (Schema::hasColumn('products', 'images')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('images');
            });
        }

        if (Schema::hasColumn('products', 'price')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('price');
            });
        }

        if (Schema::hasColumn('product_skus', 'images')) {
            Schema::table('product_skus', function (Blueprint $table) {
                $table->dropColumn('images');
            });
        }
    }
};