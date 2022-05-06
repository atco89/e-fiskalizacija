<?php
declare(strict_types=1);

namespace TaxCore\Request;

use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\Properties\RequestCustomerIdentifiedPropertiesInterface;

abstract class AdvanceSaleCustomerIdentified extends AdvanceSale implements BuyerInterface
{

    /**
     * @var string
     */
    protected string $buyerId;

    /**
     * @param RequestCustomerIdentifiedPropertiesInterface $properties
     */
    public function __construct(RequestCustomerIdentifiedPropertiesInterface $properties)
    {
        parent::__construct($properties);
        $this->buyerId = $properties->buyerId();
    }

    /**
     * @return string
     */
    public function buyerId(): string
    {
        return $this->buyerId;
    }
}
