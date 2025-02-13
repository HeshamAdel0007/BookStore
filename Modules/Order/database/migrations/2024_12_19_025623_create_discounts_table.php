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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id');
            $table->foreign('book_id')->references('id')
                ->on('books')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->decimal('discount_value', 12, 2);
            $table->enum('discount_type', ['percentage', 'fixed'])->default('percentage');
            $table->dateTime('start_at')->nullable(); // start date for discounts validity.
            $table->dateTime('expires_at')->nullable(); // end date for discounts validity.
            $table->boolean('is_active')->default(true);

            $table->index('book_id');
            $table->index('is_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
