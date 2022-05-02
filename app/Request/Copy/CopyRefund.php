<?php
declare(strict_types=1);

namespace TaxCore\Request\Copy;

use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;
use TaxCore\Entities\ReferentDocumentInterface;
use TaxCore\Request\Refund;

final class CopyRefund extends Refund
{

    /**
     * @param string $cashier
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
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
        return InvoiceType::COPY;
    }
}
