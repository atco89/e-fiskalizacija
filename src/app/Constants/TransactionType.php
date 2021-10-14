<?php
declare(strict_types=1);

namespace App\Constants;

interface TransactionType
{

    /**
     * @const int
     */
    const SALE = 0;

    /**
     * @const int
     */
    const REFUND = 1;
}
