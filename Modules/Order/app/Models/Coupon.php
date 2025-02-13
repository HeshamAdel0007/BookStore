<?php

namespace Modules\Order\Models;

use Modules\Order\Models\OrderItems;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\Enums\DiscountTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Coupon extends Model
{
    use HasFactory;
    protected $table = 'coupons';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'code',
        'discount_value',
        'discount_type',
        'usage_limit',
        'used_count',
        'valid_from',
        'valid_until',
        'is_active'
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
        return $this->belongsToMany(OrderItems::class, 'coupon_order_items', 'coupon_id', 'order_item_id');
    } // en of order
}
