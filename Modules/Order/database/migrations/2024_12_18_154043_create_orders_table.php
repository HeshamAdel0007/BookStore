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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')
                ->on('customers')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('total_price', 12, 2);
            $table->enum('currency', ['USD', 'EUR', 'SAR', 'GBP', 'INR', 'EGP'])->default('USD'); // expanded currency options

            $table->index('customer_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
