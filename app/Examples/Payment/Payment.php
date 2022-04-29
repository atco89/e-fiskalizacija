<?php
declare(strict_types=1);

namespace TaxCore\Examples\Payment;

use TaxCore\Entities\AdvancePaymentInterface;
use TaxCore\Entities\ItemsInterface;
use TaxCore\Entities\PaymentInterface;
use TaxCore\Entities\PaymentTypeInterface;

final class Payment implements PaymentInterface
{

    /**
     * @var array
     */
    private array $types;

    /**
     * @var ItemsInterface
     */
    private ItemsInterface $items;

    /**
     * @param array $types
     * @param ItemsInterface $items
     */
    public function __construct(array $types, ItemsInterface $items)
    {
        $this->types = $types;
        $this->items = $items;
    }

    /**
     * @return AdvancePaymentInterface|null
     */
    public function advancePayment(): AdvancePaymentInterface|null
    {
        $advanceAccount = $this->types['advanceAccount'];
        if (empty($advanceAccount)) {
            return null;
        }

        return new class($advanceAccount) implements AdvancePaymentInterface {

            private array $item;

            /**
             * @param array $item
             */
            public function __construct(array $item)
            {
                $this->item = $item;
            }

            /**
             * @return float
             */
            public function receivedAmount(): float
            {
                return floatval($this->item['receivedAmount']);
            }

            /**
             * @return float
             */
            public function receivedTax(): float
            {
                return floatval($this->item['receivedTax']);
            }
        };
    }

    /**
     * @return float
     */
    public function remainingAmount(): float
    {
        return round($this->items->amount() - $this->amount(), 5);
    }

    /**
     * @return float
     */
    private function amount(): float
    {
        return array_reduce($this->all(), function (float|null $carry, PaymentTypeInterface $type): float {
            $carry += $type->amount();
            return $carry;
        });
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return array_map(function (array $item): PaymentTypeInterface {
            return new PaymentItem($item);
        }, $this->types);
    }
}
