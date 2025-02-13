<?php

namespace Modules\Order\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Order\Models\OrderItems;

class OrderItemsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "id"    => $this->id,
            "quantity"  => $this->quantity,
            "total_price" => $this->total_price,
            "currency" => $this->currency,
            "items" => $this->orderItems,

        ];
    }
}
