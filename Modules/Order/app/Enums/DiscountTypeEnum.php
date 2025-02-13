<?php

namespace Modules\Order\Enums;

enum DiscountTypeEnum: string
{
    case PERCENTAGE = 'percentage';
    case FIXED = 'fixed';

    public static function getValues()
    {
        return [self::FIXED, self::PERCENTAGE];
    }
}//end of enum
