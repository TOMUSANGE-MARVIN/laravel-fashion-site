<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTransactions extends Migration
{
    public function up()
    {
        Schema::create('customer_transactions', function (Blueprint $table) {
            $table->id();
            // ...existing code...
            
            // Check if index exists before creating it
            if (!Schema::hasIndex('customer_transactions', 'customer_id')) {
                $table->index('customer_id');
            }
            // ...existing code...
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_transactions');
    }
}