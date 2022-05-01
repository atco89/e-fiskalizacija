<?php
declare(strict_types=1);

namespace TaxCore\Request\AdvanceSale;

use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Request\Sale;

final class AdvanceSale extends Sale
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
        return InvoiceType::ADVANCE;
    }
}
