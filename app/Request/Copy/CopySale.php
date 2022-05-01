<?php
declare(strict_types=1);

namespace TaxCore\Request\Copy;

use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Request\Sale;

final class CopySale extends Sale
{

    /**
     * @param string $cashier
     * @param array $items
     * @param array $payment
     */
    public function __construct(string $cashier, array $items, array $payment)
    {
        parent::__construct($cashier, $items, $payment);
    }

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::COPY;
    }
}
