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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('book_id');
            $table->string('product_name')->nullable(); // capture book name in case the book is removed or renamed.
            $table->integer('quantity');
            $table->decimal('product_price', 12, 2)->comment('price per unit');
            $table->decimal('main_total_price', 12, 2)->comment('price before taxes and discount');
            $table->decimal('discount', 12, 2)->nullable();
            $table->decimal('total_price', 12, 2)->comment('total price after taxes and discount');

            $table->foreign('order_id')->references('id')
                ->on('orders')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('book_id')->references('id')
                ->on('books')->onDelete('cascade');

            // index for improve query performance for frequent searches.
            $table->index('order_id');
            $table->index('book_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
