<?php
declare(strict_types=1);

namespace Fiskalizacija\Interfaces;

enum TransactionType: int
{
    case SALE = 0;
    case REFUND = 1;
}
