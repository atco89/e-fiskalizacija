<?php
declare(strict_types=1);

namespace TaxCore\Request;

use TaxCore\Entities\BuyerInterface;

abstract class AdvanceSaleCustomerIdentified extends AdvanceSale implements BuyerInterface
{

    /**
     * @var BuyerInterface
     */
    protected BuyerInterface $buyer;

    /**
     * @param string $cashier
     * @param array $items
     * @param array $payment
     * @param BuyerInterface $buyer
     */
    public function __construct(string $cashier, array $items, array $payment, BuyerInterface $buyer)
    {
        parent::__construct($cashier, $items, $payment);
        $this->buyer = $buyer;
    }

    /**
     * @return string
     */
    final public function buyerId(): string
    {
        return $this->buyer->buyerId();
    }
}
