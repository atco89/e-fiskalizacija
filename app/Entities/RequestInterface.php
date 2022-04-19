<?php
declare(strict_types=1);

namespace TaxCore\Entities;

interface RequestInterface extends Invoice
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
     * @return Payment[]
     */
    public function payments(): array;

    /**
     * @return Price
     */
    public function amount(): Price;
}
