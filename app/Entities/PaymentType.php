<?php
declare(strict_types=1);

namespace Fiskalizacija\Entities;

enum PaymentType: int
{
    case OTHER = 0;
    case CASH = 1;
    case CARD = 2;
    case CHECK = 3;
    case WIRE_TRANSFER = 4;
    case VOUCHER = 5;
    case MOBILE_MONEY = 6;
}
