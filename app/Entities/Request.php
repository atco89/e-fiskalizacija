<?php
declare(strict_types=1);

namespace TaxCore\Entities;

interface Request extends Invoice
{

    /**
     * @return Merchant
     */
    public function merchant(): Merchant;

    /**
     * @return Cashier
     */
    public function cashier(): Cashier;

    /**
     * @return Item[]
     */
    public function items(): array;

    /**
     * @param Payment[]
     */
    public function payments(): array;

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
    public function receivedValueAddedTax(): float;

    /**
     * @return float
     */
    public function remainingAmount(): float;
}
