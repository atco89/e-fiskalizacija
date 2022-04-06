<?php
declare(strict_types=1);

namespace Fiskalizacija\Enums;

enum TransactionType: int
{
    case SALE = 0;
    case REFUND = 0;
}
