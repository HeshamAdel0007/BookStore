<?php

namespace Modules\Order\Models;

use Modules\Order\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderStatus extends Model
{
    use HasFactory;
    protected $table = 'order_statuses';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'order_id',
        'status',
        'status_updated_at'
    ];

    // relationship with Order
    public function order(): BelongsTo
    {
        return $this->BelongsTo(Order::class);
    } //end of order
}
