<?php
declare(strict_types=1);

use TaxCore\Entities\BuyerInterface;

return new class implements BuyerInterface {

    /**
     * @return string
     */
    public function buyerId(): string
    {
        return '30:РР3456789';
    }

    /**
     * @return string|null
     */
    public function buyerCostCenterId(): string|null
    {
        return '10:099999999';
    }
};
