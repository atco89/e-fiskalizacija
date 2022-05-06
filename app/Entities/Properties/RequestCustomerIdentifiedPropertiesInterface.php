<?php
declare(strict_types=1);

namespace TaxCore\Entities\Properties;

interface RequestCustomerIdentifiedPropertiesInterface extends RequestPropertiesInterface
{

    /**
     * @return string
     */
    public function buyerId(): string;
}
