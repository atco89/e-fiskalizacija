<?php
declare(strict_types=1);

namespace TaxCore\Request\NormalSale;

use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\Properties\RequestCustomerIdentifiedPropertiesInterface;
use TaxCore\Request\CloseAdvanceSale;
use TaxCore\Response\Response;

final class NormalSaleWithClosedAdvanceSaleCustomerIdentifiedRequest extends CloseAdvanceSale implements BuyerInterface
{

    /**
     * @var string
     */
    protected string $buyerId;

    /**
     * @param RequestCustomerIdentifiedPropertiesInterface $properties
     * @param Response $response
     */
    public function __construct(
        RequestCustomerIdentifiedPropertiesInterface $properties,
        Response                                     $response
    )
    {
        parent::__construct($properties, $response);
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
