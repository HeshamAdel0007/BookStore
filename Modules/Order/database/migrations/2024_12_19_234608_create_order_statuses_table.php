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
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->enum('status', ['pending', 'processing', 'shipped', 'out_for_delivery', 'delivered', 'returned', 'canceled']);
            $table->timestamp('status_updated_at')->nullable();
            $table->foreign('order_id')->references('id')
                ->on('orders')->onUpdate('cascade')->onDelete('cascade');
            // indexes for performance improvement
            $table->index(['order_id', 'status']); // speed up queries filtering by order and status.
            $table->index('status_updated_at'); // speed up searches by the update timestamp.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_statuses');
    }
};
