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
     * @return float
     */
    public function amount(): float;

    /**
     * @return float|null
     */
    public function discount(): float|null;

    /**
     * @return float|null
     */
    public function amountWithDiscount(): float|null;

    /**
     * @return float|null
     */
    public function deposit(): float|null;

    /**
     * @return float|null
     */
    public function depositValueAddedTax(): float|null;

    /**
     * @return float
     */
    public function receivedAmount(): float;

    /**
     * @return float
     */
    public function remainingAmount(): float;
}
