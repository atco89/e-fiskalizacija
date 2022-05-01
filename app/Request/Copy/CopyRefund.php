<?php
declare(strict_types=1);

namespace TaxCore\Request\Copy;

use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Request\Refund;

final class CopyRefund extends Refund
{

    /**
     * @param string $cashier
     * @param array $items
     * @param array $payment
     * @param array $referentDocument
     */
    public function __construct(string $cashier, array $items, array $payment, array $referentDocument)
    {
        parent::__construct($cashier, $items, $payment, $referentDocument);
    }

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::COPY;
    }
}
