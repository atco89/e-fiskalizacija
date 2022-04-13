<?php
declare(strict_types=1);

namespace TaxCore\Entities;

use TaxCore\Entities\Enums\PaymentMethod;

interface Payment
{

    /**
     * @return PaymentMethod
     */
    public function type(): PaymentMethod;

    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return float
     */
    public function amount(): float;
}
