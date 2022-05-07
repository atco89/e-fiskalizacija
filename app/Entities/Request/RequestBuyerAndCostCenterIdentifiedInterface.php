<?php
declare(strict_types=1);

namespace TaxCore\Entities\Request;

interface RequestBuyerAndCostCenterIdentifiedInterface extends RequestBuyerIdentifiedInterface
{

    /**
     * @return string|null
     */
    public function buyerCostCenterId(): string|null;
}