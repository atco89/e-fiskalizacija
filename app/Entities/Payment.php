<?php
declare(strict_types=1);

namespace TaxCore\Entities;

use TaxCore\Entities\Enums\PaymentType;

interface Payment
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
}
