<?php
declare(strict_types=1);

namespace TaxCore\Request;

use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;

abstract class SaleBuyerIdentifiedBuilder extends SaleBuilder implements BuyerInterface
{

    /**
     * @var string
     */
    protected string $buyerId;

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param string $buyerId
     */
    public function __construct(array $items, array $payment, string $buyerId)
    {
        $this->buyerId = $buyerId;
        parent::__construct($items, $payment);
    }

    /**
     * @return string
     */
    public function buyerId(): string
    {
        return $this->buyerId;
    }
}
