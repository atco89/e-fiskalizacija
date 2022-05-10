<?php
declare(strict_types=1);

namespace TaxCore\Request;

use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\ItemInterface;

abstract class SaleBuyerIdentifiedBuilder extends SaleBuilder implements BuyerInterface
{

    /**
     * @var string
     */
    protected string $buyerId;

    /**
     * @param ItemInterface[] $items
     * @param string $buyerId
     */
    public function __construct(array $items, string $buyerId)
    {
        $this->buyerId = $buyerId;
        parent::__construct($items);
    }

    /**
     * @return string
     */
    public function buyerId(): string
    {
        return $this->buyerId;
    }
}
