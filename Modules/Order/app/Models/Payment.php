<?php

namespace Modules\Order\Models;

use Modules\Customer\Models\Customer;
use Modules\Order\Enums\CurrencyEnum;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\Enums\PaymentMethodEnum;
use Modules\Order\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'order_id',
        'customer_id',
        'transaction_id',
        'payment_method',
        'taxes_rate',
        'taxes_total',
        'currency',
        'order_amount',
        'coupon_discount',
        'total_price',
        'paid_at'
    ];

    protected function casts(): array
    {
        return [
            'currency' => CurrencyEnum::class,
            'payment_method' => PaymentMethodEnum::class,
        ];
    } // End of casts

    // relationship with Order
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    } // end of order

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    } // end of customer
}
