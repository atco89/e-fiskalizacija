<?php
declare(strict_types=1);

namespace TaxCore\Entities\Enums;

enum TransactionType: int
{

    case SALE = 0;

    case REFUND = 1;
}
