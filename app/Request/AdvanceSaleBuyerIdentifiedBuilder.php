<?php
declare(strict_types=1);

namespace TaxCore\Request;

use TaxCore\Entities\AdvanceSaleItemInterface;
use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\ItemInterface;

abstract class AdvanceSaleBuyerIdentifiedBuilder extends AdvanceSaleBuilder implements BuyerInterface
{

    /**
     * @var string
     */
    protected string $buyerId;

    /**
     * @param ItemInterface[] $items
     * @param AdvanceSaleItemInterface[] $advanceSaleItems
     * @param string $buyerId
     */
    public function __construct(array $items, array $advanceSaleItems, string $buyerId)
    {
        $this->buyerId = $buyerId;
        parent::__construct($items, $advanceSaleItems);
    }

    /**
     * @return string
     */
    public function buyerId(): string
    {
        return $this->buyerId;
    }
}
