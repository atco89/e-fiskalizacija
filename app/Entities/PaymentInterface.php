<?php
declare(strict_types=1);

namespace TaxCore\Entities;

interface PaymentInterface
{

    /**
     * @return array
     */
    public function all(): array;

    /**
     * @return float
     */
    public function amount(): float;

    /**
     * @return float
     */
    public function deposit(): float;

    /**
     * @return float
     */
    public function taxOnDeposit(): float;

    /**
     * @return float
     */
    public function remainingAmount(): float;
}
