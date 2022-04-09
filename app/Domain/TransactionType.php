<?php
declare(strict_types=1);

namespace Fiskalizacija\Domain;

enum TransactionType: int
{
    case SALE = 0;
    case REFUND = 1;
}
