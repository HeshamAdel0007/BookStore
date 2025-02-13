<?php

namespace Modules\Order\Models;

use Modules\Book\Models\Book;
use Modules\Order\Models\Order;
use Modules\Order\Models\Coupon;
use Modules\Order\Models\Discount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OrderItems extends Model
{
    use HasFactory;
    protected $table = 'order_items';


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'order_id',
        'book_id',
        'product_name',
        'quantity',
        'product_price',
        'main_total_price',
        'discount',
        'total_price'
    ];

    // relationship with Order
    public function order(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    } //end of order

    // relationship with Book
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    } //end of book

    // relationship with Discounts
    public function discounts(): HasMany
    {
        return $this->hasMany(Discount::class);
    } //end of discounts

    // relationship with Coupons
    public function coupons(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    } //end of discounts
}
