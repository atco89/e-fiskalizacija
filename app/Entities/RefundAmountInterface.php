<?php
declare(strict_types=1);

namespace TaxCore\Entities;

interface RefundAmountInterface
{

    /**
     * @return float
     */
    public function receivedAmount(): float;

    /**
     * @return float
     */
    public function receivedTax(): float;
}