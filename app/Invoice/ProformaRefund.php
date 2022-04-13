<?php
declare(strict_types=1);

namespace TaxCore\Invoice;

use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\Enums\TransactionType;
use TaxCore\Sale;

final class ProformaRefund extends Sale
{

    /**
     * @return InvoiceType
     */
    protected function invoiceType(): InvoiceType
    {
        return InvoiceType::PROFORMA;
    }

    /**
     * @return TransactionType
     */
    protected function transactionType(): TransactionType
    {
        return TransactionType::REFUND;
    }
}