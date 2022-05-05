<?php
declare(strict_types=1);

namespace TaxCore\Request\NormalSale;

use TaxCore\Entities\BuyerCostCenterInterface;
use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Request\SaleCustomerIdentified;

final class NormalSaleCustomerIdentifiedRequest extends SaleCustomerIdentified implements BuyerCostCenterInterface
{

    /**
     * @var BuyerCostCenterInterface
     */
    private BuyerCostCenterInterface $buyerCostCenter;

    /**
     * @param string $cashier
     * @param array $items
     * @param array $payment
     * @param BuyerInterface $buyer
     * @param BuyerCostCenterInterface $buyerCostCenter
     */
    public function __construct(
        string                   $cashier,
        array                    $items,
        array                    $payment,
        BuyerInterface           $buyer,
        BuyerCostCenterInterface $buyerCostCenter
    )
    {
        parent::__construct($cashier, $items, $payment, $buyer);
        $this->buyerCostCenter = $buyerCostCenter;
    }

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::NORMAL;
    }

    /**
     * @return string|null
     */
    public function buyerCostCenterId(): string|null
    {
        return $this->buyerCostCenter->buyerCostCenterId();
    }
}
