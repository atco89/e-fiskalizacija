<?php
declare(strict_types=1);

namespace TaxCore\Request\AdvanceSale;

use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;
use TaxCore\Request\SaleCustomerIdentified;

final class AdvanceSaleCustomer extends SaleCustomerIdentified
{

    /**
     * @param string $cashier
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param BuyerInterface $buyer
     */
    public function __construct(string $cashier, array $items, array $payment, BuyerInterface $buyer)
    {
        parent::__construct($cashier, $items, $payment, $buyer);
    }

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::ADVANCE;
    }
}
