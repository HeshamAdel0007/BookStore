<?php

namespace Modules\Order\Models;

use Modules\Order\Models\Payment;
use Modules\Order\Models\OrderItems;
use Modules\Customer\Models\Customer;
use Modules\Order\Enums\CurrencyEnum;
use Modules\Order\Models\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';

    protected $fillable = [
        'customer_id',
        'quantity',
        'discount',
        'total_price',
        'currency',
    ];

    protected function casts(): array
    {
        return [
            'currency' => CurrencyEnum::class,
        ];
    } // End of casts

    public function getCurrencySymbol(): string
    {
        return $this->currency->getSymbol();
    } //end of getCurrencySymbol

    // relationship with Customer
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    } //end of customer

    // relationship with OrderItems
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItems::class, 'order_id');
    } //end of orderItems

    // relationship with Payments
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class)->withDefault();
    } //end of payments

    // relationship with Shipping

    // relationship with OrderStatus order to have only one status
    public function status(): HasOne
    {
        return $this->hasOne(OrderStatus::class)->withDefault();
    } //end of status
}
