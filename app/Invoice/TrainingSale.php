<?php
declare(strict_types=1);

namespace Fiskalizacija\Invoice;

use Fiskalizacija\Interfaces\Configuration;
use Fiskalizacija\Interfaces\Invoice;
use Fiskalizacija\Interfaces\InvoiceType;
use Fiskalizacija\Interfaces\TransactionType;
use Fiskalizacija\Sale;

final class TrainingSale extends Sale
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
        return InvoiceType::TRAINING;
    }

    /**
     * @return TransactionType
     */
    protected function transactionType(): TransactionType
    {
        return TransactionType::SALE;
    }
}