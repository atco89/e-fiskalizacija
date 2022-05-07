<?php
declare(strict_types=1);

namespace TaxCore\Entities;

interface BuyerCostCenterInterface
{

    /**
     * @return string|null
     */
    public function buyerCostCenterId(): string|null;
}
