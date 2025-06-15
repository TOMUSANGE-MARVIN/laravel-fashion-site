<?php
/* */

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
        Schema::create('weight_classes', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->string('code', 16)->unique()->comment('Unit code');
            $table->string('name')->comment('Unit name');
            $table->string('unit')->comment('Unit symbol');
            $table->decimal('value', 15, 8)->default(1)->comment('Conversion rate');
            $table->integer('position')->default(0)->comment('Sort order');
            $table->boolean('active')->default(true)->comment('Status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weight_classes');
    }
};
