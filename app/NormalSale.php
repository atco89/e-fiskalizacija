<?php
declare(strict_types=1);

namespace Fiskalizacija;

use Fiskalizacija\Enums\InvoiceType;
use Fiskalizacija\Enums\TransactionType;
use Fiskalizacija\Sale\Sale;

final class NormalSale extends Sale
{

    /**
     * @return int
     */
    protected function invoiceType(): int
    {
        return InvoiceType::NORMAL->value;
    }

    /**
     * @return int
     */
    protected function transactionType(): int
    {
        return TransactionType::SALE->value;
    }
}
