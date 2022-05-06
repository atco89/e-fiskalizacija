<?php
declare(strict_types=1);

namespace TaxCore\Examples\Request;

use TaxCore\Entities\Properties\RequestCustomerIdentifiedWithCostCenterPropertiesInterface;

final class RequestCustomerIdentifiedWithCostCenterProperties
    implements RequestCustomerIdentifiedWithCostCenterPropertiesInterface
{

    /**
     * @return string
     */
    public function buyerId(): string
    {
        return include __DIR__ . '/../data/buyer_id.php';
    }

    /**
     * @return string|null
     */
    public function buyerCostCenterId(): string|null
    {
        return include __DIR__ . '/../data/buyer_cost_center_id.php';
    }

    /**
     * @return array
     */
    public function items(): array
    {
        return include __DIR__ . '/../data/items.php';
    }

    /**
     * @return array
     */
    public function payment(): array
    {
        return include __DIR__ . '/../data/payment.php';
    }
}