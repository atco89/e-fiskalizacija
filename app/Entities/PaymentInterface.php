<?php
declare(strict_types=1);

namespace TaxCore\Entities;

use TaxCore\Entities\Enums\PaymentType;

interface PaymentInterface
{

    /**
     * @return PaymentType
     */
    public function type(): PaymentType;

    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return float
     */
    public function amount(): float;

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
