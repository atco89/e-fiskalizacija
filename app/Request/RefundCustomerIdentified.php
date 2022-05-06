<?php
declare(strict_types=1);

namespace TaxCore\Request;

use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\Properties\RequestRefundCustomerIdentifiedPropertiesInterface;

abstract class RefundCustomerIdentified extends Refund implements BuyerInterface
{

    /**
     * @var string
     */
    protected string $buyerId;

    /**
     * @param RequestRefundCustomerIdentifiedPropertiesInterface $properties
     */
    public function __construct(RequestRefundCustomerIdentifiedPropertiesInterface $properties)
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
