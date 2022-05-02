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
     * @param array $items
     * @param array $payment
     * @param ReferentDocumentInterface $document
     */
    public function __construct(string $cashier, array $items, array $payment, ReferentDocumentInterface $document)
    {
        parent::__construct($cashier, $items, $payment, $document);
    }

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::NORMAL;
    }
}
