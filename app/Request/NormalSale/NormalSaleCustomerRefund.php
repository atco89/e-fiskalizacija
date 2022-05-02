<?php
declare(strict_types=1);

namespace TaxCore\Request\NormalSale;

use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\ReferentDocumentInterface;
use TaxCore\Request\RefundCustomerIdentified;

final class NormalSaleCustomerRefund extends RefundCustomerIdentified
{

    /**
     * @param string $cashier
     * @param array $items
     * @param array $payment
     * @param ReferentDocumentInterface $document
     * @param BuyerInterface $buyer
     */
    public function __construct(
        string                    $cashier,
        array                     $items,
        array                     $payment,
        ReferentDocumentInterface $document,
        BuyerInterface            $buyer
    )
    {
        parent::__construct($cashier, $items, $payment, $document, $buyer);
    }

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::NORMAL;
    }
}
