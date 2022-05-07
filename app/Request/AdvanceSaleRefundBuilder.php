<?php
declare(strict_types=1);

namespace TaxCore\Request;

use TaxCore\Entities\AdvanceSaleItemInterface;
use TaxCore\Entities\AdvertisementItemInterface;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\Request\RequestInterface;

abstract class AdvanceSaleRefundBuilder extends RefundBuilder
{

    /**
     * @var AdvanceSaleItemInterface[]
     */
    protected array $advanceSaleItems;

    /**
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        $this->advanceSaleItems = $request->advanceSaleItems();
        parent::__construct($request);
    }

    /**
     * @return ItemInterface[]
     * @noinspection DuplicatedCode
     */
    final public function items(): array
    {
        return array_map(function (AdvanceSaleItemInterface $item): ItemInterface {
            return $this->buildAdvanceSaleItem($item);
        }, $this->advanceSaleItems);
    }

    /**
     * @param AdvanceSaleItemInterface $item
     * @return ItemInterface
     */
    final protected function buildAdvanceSaleItem(AdvanceSaleItemInterface $item): ItemInterface
    {
        return new class($item) implements ItemInterface {

            /**
             * @const int
             */
            const DEFAULT_QUANTITY = 1.00;

            /**
             * @var AdvanceSaleItemInterface
             */
            private AdvanceSaleItemInterface $item;

            /**
             * @param AdvanceSaleItemInterface $item
             */
            public function __construct(AdvanceSaleItemInterface $item)
            {
                $this->item = $item;
            }

            /**
             * @return string
             */
            private function buildName(): string
            {
                return implode(': ', [
                    trim(str_replace('TL', '', $this->item->taxRateLabel()->name)), 'Аванс'
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
                return $this->item->amount();
            }

            /**
             * @return string[]
             */
            public function labels(): array
            {
                return [$this->item->taxRateLabel()->value];
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
