<?php
declare(strict_types=1);

namespace TaxCore\Entities;

use TaxCore\Entities\Enums\TaxRateLabel;

interface AdvanceSaleItemInterface
{

    /**
     * @return float
     */
    public function amount(): float;

    /**
     * @return TaxRateLabel
     */
    public function taxRateLabel(): TaxRateLabel;
}
