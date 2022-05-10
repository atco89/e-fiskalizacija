<?php
declare(strict_types=1);

namespace TaxCore\Request;

use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\Enums\TaxRateLabel;

abstract class AdvanceSaleBuyerIdentifiedBuilder extends AdvanceSaleBuilder implements BuyerInterface
{

    /**
     * @var string
     */
    protected string $buyerId;

    /**
     * @param array $items
     * @param TaxRateLabel $taxRateLabel
     * @param float $recievedAmount
     * @param string $buyerId
     */
    public function __construct(array $items, TaxRateLabel $taxRateLabel, float $recievedAmount, string $buyerId)
    {
        parent::__construct($items, $taxRateLabel, $recievedAmount);
        $this->buyerId = $buyerId;
    }

    /**
     * @return string
     */
    public function buyerId(): string
    {
        return $this->buyerId;
    }
}
