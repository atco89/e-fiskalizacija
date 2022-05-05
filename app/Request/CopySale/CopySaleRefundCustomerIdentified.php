<?php
declare(strict_types=1);

namespace TaxCore\Request\CopySale;

use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Request\RefundCustomerIdentified;

final class CopySaleRefundCustomerIdentified extends RefundCustomerIdentified
{

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::COPY;
    }
}
