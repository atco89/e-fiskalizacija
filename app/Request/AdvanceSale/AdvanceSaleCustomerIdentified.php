<?php
declare(strict_types=1);

namespace TaxCore\Request\AdvanceSale;

use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Request\SaleCustomerIdentified;

final class AdvanceSaleCustomerIdentified extends SaleCustomerIdentified
{

    /**
     * @param string $cashier
     * @param string $invoiceNumber
     * @param array $items
     * @param array $payment
     * @param BuyerInterface $buyer
     */
    public function __construct(
        string         $cashier,
        string         $invoiceNumber,
        array          $items,
        array          $payment,
        BuyerInterface $buyer
    )
    {
        parent::__construct($cashier, $invoiceNumber, $items, $payment, $buyer);
    }

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::ADVANCE;
    }
}
