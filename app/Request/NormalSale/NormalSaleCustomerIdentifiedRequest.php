<?php
declare(strict_types=1);

namespace TaxCore\Request\NormalSale;

use TaxCore\Entities\BuyerCostCenterInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\Properties\RequestCustomerIdentifiedWithCostCenterPropertiesInterface;
use TaxCore\Request\SaleCustomerIdentified;

final class NormalSaleCustomerIdentifiedRequest extends SaleCustomerIdentified implements BuyerCostCenterInterface
{

    /**
     * @var string|null
     */
    protected string|null $buyerCostCenterId;

    /**
     * @param RequestCustomerIdentifiedWithCostCenterPropertiesInterface $properties
     */
    public function __construct(RequestCustomerIdentifiedWithCostCenterPropertiesInterface $properties)
    {
        parent::__construct($properties);
        $this->buyerCostCenterId = $properties->buyerCostCenterId();
    }

    /**
     * @return string|null
     */
    public function buyerCostCenterId(): string|null
    {
        return $this->buyerCostCenterId;
    }

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::NORMAL;
    }
}
