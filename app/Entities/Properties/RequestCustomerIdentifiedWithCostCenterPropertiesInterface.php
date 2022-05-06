<?php
declare(strict_types=1);

namespace TaxCore\Entities\Properties;

interface RequestCustomerIdentifiedWithCostCenterPropertiesInterface
    extends RequestCustomerIdentifiedPropertiesInterface
{

    /**
     * @return string|null
     */
    public function buyerCostCenterId(): string|null;
}
