<?php
declare(strict_types=1);

namespace TaxCore\Request\NormalSale;

use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\ReferentDocumentInterface;
use TaxCore\Request\RefundCustomerIdentified;

final class NormalSaleRefundCustomerIdentified extends RefundCustomerIdentified
{

    /**
     * @param string $cashier
     * @param string $invoiceNumber
     * @param array $items
     * @param array $payment
     * @param ReferentDocumentInterface $referentDocument
     * @param BuyerInterface $buyer
     */
    public function __construct(
        string                    $cashier,
        string                    $invoiceNumber,
        array                     $items,
        array                     $payment,
        ReferentDocumentInterface $referentDocument,
        BuyerInterface            $buyer
    )
    {
        parent::__construct($cashier, $invoiceNumber, $items, $payment, $referentDocument, $buyer);
    }

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::NORMAL;
    }
}
