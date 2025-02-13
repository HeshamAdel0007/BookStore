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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')
                ->on('orders')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')
                ->on('customers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('transaction_id', 64)->unique(); // store a unique ID for the transaction.
            $table->enum('payment_method', ['credit_card', 'paypal', 'bank_transfer', 'cash_on_delivery', 'wallet'])->nullable();
            $table->enum('currency', ['USD', 'EUR', 'SAR', 'GBP', 'INR', 'EGP'])->default('USD');
            $table->decimal('taxes_rate', 5, 2)->default(0.00);
            $table->decimal('taxes_total', 12, 2)->default(0.00); // stores taxes portion of the payment.
            $table->decimal('order_amount', 12, 2);
            $table->decimal('coupon_discount', 12, 2)->nullable();
            $table->decimal('total_price', 12, 2);
            $table->dateTime('paid_at'); // timestamp for when the payment was completed.

            // indexes for performance improvement
            $table->index('order_id'); // index for faster order lookups.
            $table->index('transaction_id'); // index for faster transaction lookups.
            $table->index('payment_status'); // index to speed up filtering by status.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
