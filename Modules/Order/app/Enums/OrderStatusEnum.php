<?php

namespace Modules\Order\Enums;

enum OrderStatusEnum: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case SHIPPED = 'shipped';
    case OUT_FOR_DELIVERY = 'out_for_delivery';
    case DELIVERED = 'delivered';
    case RETURNED = 'returned';
    case CANCELED = 'canceled';
}//end of enum
