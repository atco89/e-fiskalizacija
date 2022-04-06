<?php
declare(strict_types=1);

namespace Fiskalizacija\Enums;

enum PaymentType: int
{
    case OTHER = 1;
    case CASH = 2;
    case CARD = 3;
    case CHECK = 4;
    case WIRE_TRANSFER = 5;
    case VOUCHER = 6;
    case MOBILE_MONEY = 7;
}
