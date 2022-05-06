<?php
declare(strict_types=1);

namespace TaxCore\Entities\Properties;

interface RequestRefundCustomerIdentifiedPropertiesInterface extends RequestRefundPropertiesInterface
{

    /**
     * @return string
     */
    public function buyerId(): string;
}
