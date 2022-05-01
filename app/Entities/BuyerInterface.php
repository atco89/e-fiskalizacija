<?php
declare(strict_types=1);

namespace TaxCore\Entities;

interface BuyerInterface
{

    /**
     * @return string
     */
    public function buyerId(): string;

    /**
     * @return string|null
     */
    public function buyerCostCenterId(): string|null;
}