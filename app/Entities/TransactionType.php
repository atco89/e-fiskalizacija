<?php
declare(strict_types=1);

namespace TaxCore\Entities;

enum TransactionType: int
{
    case SALE = 0;
    case REFUND = 1;
}
