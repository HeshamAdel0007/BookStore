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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->decimal('discount_value', 12, 2);
            $table->enum('discount_type', ['percentage', 'fixed']);
            $table->unsignedBigInteger('usage_limit')->default(10); // maximum number of uses for the coupon.
            $table->unsignedBigInteger('used_count')->default(0); // tracks how many times the coupon has been used.
            $table->dateTime('start_at')->nullable(); // start date for coupon validity.
            $table->dateTime('expires_at')->nullable(); // end date for coupon validity.
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
