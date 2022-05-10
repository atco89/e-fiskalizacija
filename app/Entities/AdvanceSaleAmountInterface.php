<?php
declare(strict_types=1);

namespace TaxCore\Entities;

interface AdvanceSaleAmountInterface
{

    /**
     * @return float
     */
    public function receivedAmount(): float;

    /**
     * @return float
     */
    public function receivedTax(): float;

    /**
     * @return float
     */
    public function remainingAmount(): float;
}
