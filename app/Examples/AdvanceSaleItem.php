<?php
declare(strict_types=1);

namespace TaxCore\Examples;

use TaxCore\Entities\AdvanceSaleItemInterface;
use TaxCore\Entities\Enums\TaxRateLabel;

final class AdvanceSaleItem implements AdvanceSaleItemInterface
{

    /**
     * @var array
     */
    protected array $item;

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
    public function amount(): float
    {
        return floatval($this->item['amount']);
    }

    /**
     * @return TaxRateLabel
     */
    public function taxRateLabel(): TaxRateLabel
    {
        return $this->item['taxRateLabel'];
    }
}
