<?php
declare(strict_types=1);

namespace TaxCore\Request\NormalSale;

use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\ReferentDocumentInterface;
use TaxCore\Request\Refund;

final class NormalSaleRefund extends Refund
{

    /**
     * @param string $cashier
     * @param string $invoiceNumber
     * @param array $items
     * @param array $payment
     * @param ReferentDocumentInterface $referentDocument
     */
    public function __construct(
        string                    $cashier,
        string                    $invoiceNumber,
        array                     $items,
        array                     $payment,
        ReferentDocumentInterface $referentDocument
    )
    {
        parent::__construct($cashier, $invoiceNumber, $items, $payment, $referentDocument);
    }

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::NORMAL;
    }
}
