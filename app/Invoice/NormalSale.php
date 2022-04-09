<?php
declare(strict_types=1);

namespace Fiskalizacija\Invoice;

use Fiskalizacija\Entities\Configuration;
use Fiskalizacija\Entities\Invoice;
use Fiskalizacija\Entities\InvoiceType;
use Fiskalizacija\Entities\TransactionType;
use Fiskalizacija\Sale;

final class NormalSale extends Sale
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
        return InvoiceType::NORMAL;
    }

    /**
     * @return TransactionType
     */
    protected function transactionType(): TransactionType
    {
        return TransactionType::SALE;
    }
}
