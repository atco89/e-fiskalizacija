<?php
declare(strict_types=1);

namespace TaxCore\Entities;

interface Buyer
{

    /**
     * @return string|null
     */
    public function buyerId(): ?string;

    /**
     * @return string|null
     */
    public function buyerCostCenterId(): ?string;
}