<?php

namespace Modules\Order\Models;

use Modules\Book\Models\Book;
use Modules\Order\Models\OrderItems;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Order\Enums\DiscountTypeEnum;

class Discount extends Model
{
    use HasFactory;
    protected $table = 'discounts';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'book_id',
        'discount_value',
        'discount_type',
        'start_at',
        'expires_at',
        'is_active',
    ];
    protected function casts(): array
    {
        return [
            'discount_type' => DiscountTypeEnum::class,
        ];
    } // End of casts

    // relationship with OrderItems
    public function orderItems(): BelongsToMany
    {
        return $this->belongsToMany(OrderItems::class, 'discount_order_items', 'discount_id', 'order_item_id');
    } //end of orderItems

    public function books()
    {
        return $this->hasOne(Book::class);
    } //end of books
}
