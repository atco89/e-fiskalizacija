<?php
declare(strict_types=1);

use TaxCore\Entities\BuyerCostCenterInterface;

return new class implements BuyerCostCenterInterface {

    /**
     * @return string|null
     */
    public function buyerCostCenterId(): string|null
    {
        return '10:099999999';
    }
};
