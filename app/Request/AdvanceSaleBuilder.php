<?php
declare(strict_types=1);

namespace TaxCore\Request;

use TaxCore\Entities\AdvertisementItemInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\Enums\TaxRateLabel;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;

abstract class AdvanceSaleBuilder extends SaleBuilder
{

    /**
     * @var TaxRateLabel
     */
    protected TaxRateLabel $taxRateLabel;

    /**
     * @var float
     */
    protected float $receivedAmount;

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param TaxRateLabel $taxRateLabel
     * @param float $receivedAmount
     */
    public function __construct(array $items, array $payment, TaxRateLabel $taxRateLabel, float $receivedAmount)
    {
        $this->taxRateLabel = $taxRateLabel;
        $this->receivedAmount = $receivedAmount;
        parent::__construct($items, $payment);
    }

    /**
     * @return InvoiceType
     */
    final public function invoiceType(): InvoiceType
    {
        return InvoiceType::ADVANCE;
    }

    /**
     * @return ItemInterface[]
     * @noinspection DuplicatedCode
     */
    final public function items(): array
    {
        return [$this->buildAdvanceSaleItem($this->taxRateLabel, $this->receivedAmount)];
    }

    /**
     * @param TaxRateLabel $taxRateLabel
     * @param float $amount
     * @return ItemInterface
     * @noinspection DuplicatedCode
     */
    final protected function buildAdvanceSaleItem(TaxRateLabel $taxRateLabel, float $amount): ItemInterface
    {
        return new class($taxRateLabel, $amount) implements ItemInterface {

            /**
             * @const int
             */
            const DEFAULT_QUANTITY = 1.00;

            /**
             * @var TaxRateLabel
             */
            protected TaxRateLabel $taxRateLabel;

            /**
             * @var float
             */
            protected float $amount;

            /**
             * @param TaxRateLabel $taxRateLabel
             * @param float $amount
             */
            public function __construct(TaxRateLabel $taxRateLabel, float $amount)
            {
                $this->taxRateLabel = $taxRateLabel;
                $this->amount = $amount;
            }

            /**
             * @return string
             */
            private function buildName(): string
            {
                return implode(': ', [
                    trim(str_replace('TL', '', $this->taxRateLabel->name)), 'Аванс'
                ]);
            }

            /**
             * @return string|null
             */
            public function gtin(): string|null
            {
                return null;
            }

            /**
             * @return string
             */
            public function name(): string
            {
                return $this->buildName();
            }

            /**
             * @return float
             */
            public function quantity(): float
            {
                return self::DEFAULT_QUANTITY;
            }

            /**
             * @return float
             */
            public function unitPrice(): float
            {
                return $this->amount;
            }

            /**
             * @return string[]
             */
            public function labels(): array
            {
                return [$this->taxRateLabel->value];
            }

            /**
             * @return float
             */
            public function amount(): float
            {
                return round($this->unitPrice() * $this->quantity(), 5);
            }
        };
    }

    /**
     * @return AdvertisementItemInterface[]
     */
    final public function advertisementItems(): array
    {
        return $this->items;
    }
}