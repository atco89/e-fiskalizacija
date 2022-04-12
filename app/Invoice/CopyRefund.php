<?php
declare(strict_types=1);

namespace TaxCore\Invoice;

use TaxCore\Entities\Configuration;
use TaxCore\Entities\Invoice;
use TaxCore\Entities\InvoiceType;
use TaxCore\Entities\TransactionType;
use TaxCore\Sale;

final class CopyRefund extends Sale
{

    /**
     * @param Configuration $configuration
     * @param Invoice $invoice
     */
    public function __construct(Configuration $configuration, Invoice $invoice)
    {
        parent::__construct($configuration, $invoice);
    }

    /**
     * @return InvoiceType
     */
    protected function invoiceType(): InvoiceType
    {
        return InvoiceType::COPY;
    }

    /**
     * @return TransactionType
     */
    protected function transactionType(): TransactionType
    {
        return TransactionType::REFUND;
    }
}