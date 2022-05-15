<?php
declare(strict_types=1);

namespace TaxCore\Request;

use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\Enums\TaxRateLabel;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;

abstract class AdvanceSaleBuyerIdentifiedBuilder extends AdvanceSaleBuilder implements BuyerInterface
{

    /**
     * @var string
     */
    protected string $buyerId;

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param TaxRateLabel $taxRateLabel
     * @param float $recievedAmount
     * @param string $buyerId
     */
    public function __construct(
        array        $items,
        array        $payment,
        TaxRateLabel $taxRateLabel,
        float        $recievedAmount,
        string       $buyerId
    )
    {
        $this->buyerId = $buyerId;
        parent::__construct($items, $payment, $taxRateLabel, $recievedAmount);
    }

    /**
     * @return string
     */
    public function buyerId(): string
    {
        return $this->buyerId;
    }
}
