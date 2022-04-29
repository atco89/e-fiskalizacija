<?php
declare(strict_types=1);

namespace TaxCore\Entities;

interface PaymentInterface
{

    /**
     * @return PaymentTypeInterface[]
     */
    public function all(): array;

    /**
     * @return AdvancePaymentInterface|null
     */
    public function advancePayment(): AdvancePaymentInterface|null;
}
