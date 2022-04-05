<?php
declare(strict_types=1);

namespace Fiskalizacija\Invoice;

final class Item
{

    /**
     * @var string
     */
    private string $name;

    /**
     * @var float
     */
    private float $price;

    /**
     * @var float
     */
    private float $quantity;

    /**
     * @var float
     */
    private float $amount;

    /**
     * @param string $name
     * @param float $price
     * @param float $quantity
     * @param float $amount
     */
    public function __construct(string $name, float $price, float $quantity, float $amount)
    {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return float
     */
    public function getQuantity(): float
    {
        return $this->quantity;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }
}