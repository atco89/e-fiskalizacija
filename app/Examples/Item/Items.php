<?php
declare(strict_types=1);

namespace TaxCore\Examples\Item;

use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\ItemsInterface;

final class Items implements ItemsInterface
{

    /**
     * @var array
     */
    private array $items;

    /**
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return float
     */
    public function amount(): float
    {
        return array_reduce($this->all(), function (float|null $carry, ItemInterface $item): float {
            $carry += $item->amount();
            return $carry;
        });
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return array_map(function (array $item): ItemInterface {
            return new Item($item);
        }, $this->items);
    }
}
