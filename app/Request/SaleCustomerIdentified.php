<?php
declare(strict_types=1);

namespace TaxCore\Request;

use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;

abstract class SaleCustomerIdentified extends Sale implements BuyerInterface
{

    /**
     * @var BuyerInterface
     */
    protected BuyerInterface $buyer;

    /**
     * @param string $cashier
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
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

    /**
     * @return string|null
     */
    final public function buyerCostCenterId(): string|null
    {
        return $this->buyer->buyerCostCenterId();
    }
}
