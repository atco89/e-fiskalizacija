<?php
declare(strict_types=1);

namespace TaxCore\Examples\Item;

use TaxCore\Entities\ItemInterface;

final class Item implements ItemInterface
{

    /**
     * @var array
     */
    private array $item;

    /**
     * @param array $item
     */
    public function __construct(array $item)
    {
        $this->item = $item;
    }

    /**
     * @return string|null
     */
    public function gtin(): string|null
    {
        return $this->item['gtin'];
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->item['name'];
    }

    /**
     * @return array
     */
    public function labels(): array
    {
        return [$this->item['labels']];
    }

    /**
     * @return float
     */
    public function amount(): float
    {
        return round($this->unitPrice() * $this->quantity(), 5);
    }

    /**
     * @return float
     */
    public function unitPrice(): float
    {
        return floatval($this->item['unitPrice']);
    }

    /**
     * @return float
     */
    public function quantity(): float
    {
        return floatval($this->item['quantity']);
    }
}
