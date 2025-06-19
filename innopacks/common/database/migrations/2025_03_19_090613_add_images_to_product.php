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
                $table->decimal('price')->default(0)->after('brand_id');
            });
        }

        if (!Schema::hasColumn('product_skus', 'images')) {
            Schema::table('product_skus', function (Blueprint $table) {
                $table->json('images')->nullable()->after('product_id');
            });
        }

        // Drop columns using SQLite-compatible approach
        $columns = ['product_image_id', 'product_video_id', 'product_sku_id'];
        foreach ($columns as $column) {
            if (Schema::hasColumn('products', $column)) {
                // Create new table without the column
                DB::statement("CREATE TEMPORARY TABLE products_backup AS SELECT * FROM products");
                Schema::drop('products');
                
                // Recreate table without the column
                Schema::create('products', function (Blueprint $table) {
                    $table->id();
                    // Add all columns except the one to drop
                    // This assumes you have access to the current schema
                    $table->string('name');
                    $table->json('images')->nullable();
                    $table->decimal('price')->default(0);
                    // ... add other columns as needed
                    $table->timestamps();
                });

                // Copy data back
                DB::statement("INSERT INTO products SELECT * FROM products_backup");
                DB::statement("DROP TABLE products_backup");
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void 
    {
        // Add rollback logic if needed
    }
};
