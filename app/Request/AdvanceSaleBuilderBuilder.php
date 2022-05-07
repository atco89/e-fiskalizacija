<?php
declare(strict_types=1);

namespace TaxCore\Request;

use TaxCore\Entities\AdvertisementItemInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\Enums\TaxLabel;
use TaxCore\Entities\ItemInterface;

abstract class AdvanceSaleBuilderBuilder extends SaleBuilder
{

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
        $amounts = [TaxLabel::T0->value => 0.00, TaxLabel::T1->value => 0.00, TaxLabel::T2->value => 0.00];
        foreach ($this->items as $item) {
            $labels = $item->labels();
            $amount = $item->amount();
            if (in_array(TaxLabel::T0->value, $labels)) {
                $amounts[TaxLabel::T0->value] += $amount;
            } else if (in_array(TaxLabel::T1->value, $labels)) {
                $amounts[TaxLabel::T1->value] += $amount;
            } else if (in_array(TaxLabel::T2->value, $labels)) {
                $amounts[TaxLabel::T2->value] += $amount;
            }
        }

        $items = [];
        foreach ($amounts as $label => $amount) {
            $items[] = $this->buildAdvanceSaleItem($label, $amount);
        }
        return $items;
    }

    /**
     * @param string $label
     * @param float $amount
     * @return ItemInterface
     */
    final protected function buildAdvanceSaleItem(string $label, float $amount): ItemInterface
    {
        return new class($label, $amount) implements ItemInterface {

            /**
             * @var int
             */
            private int $id;

            /**
             * @var string
             */
            private string $label;

            /**
             * @var float
             */
            private float $amount;

            /**
             * @param string $label
             * @param float $amount
             */
            public function __construct(string $label, float $amount)
            {
                $this->id = $this->loadId($label);
                $this->label = $label;
                $this->amount = $amount;
            }

            /**
             * @param string $label
             * @return int
             */
            private function loadId(string $label): int
            {
                $labels = [TaxLabel::T0->value => 10, TaxLabel::T1->value => 11, TaxLabel::T2->value => 12];
                return $labels[$label];
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
                return "$this->id: Аванс";
            }

            /**
             * @return float
             */
            public function quantity(): float
            {
                return 1.00;
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
                return [$this->label];
            }

            /**
             * @return float
             */
            public function amount(): float
            {
                return $this->amount;
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