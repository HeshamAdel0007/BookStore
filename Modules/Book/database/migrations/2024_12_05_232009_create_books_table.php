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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->constrained(table: 'categories')->cascadeOnDelete();
            $table->foreignId('publisher_id')
                ->constrained(table: 'publishers')->cascadeOnDelete();
            $table->string('name')->unique();
            $table->string('slug');
            $table->decimal('price', 12, 2);
            $table->integer('stock_quantity')->default(1);
            $table->string('isbn')->unique()->nullable();
            $table->date('published_date')->nullable();
            $table->string('sku')->unique()->nullable(); // reference stock-keeping units.
            $table->float('average_rating', 53)->default(0.0);
            $table->unsignedInteger('review_count')->default(0);
            $table->text('description')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // index for improve query performance for frequent searches.
            $table->index(['name', 'sku']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
