<?php
declare(strict_types=1);

namespace TaxCore\Request\AdvanceSale\Item;

use TaxCore\Entities\Enums\TaxLabel;
use TaxCore\Entities\ItemInterface;

final class AdvanceSaleItem implements ItemInterface
{

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
     * @noinspection PhpPureAttributeCanBeAddedInspection
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
}
