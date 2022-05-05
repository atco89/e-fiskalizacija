<?php
declare(strict_types=1);

namespace TaxCore\Request\CopySale;

use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Request\Refund;

final class CopySaleRefundRequest extends Refund
{

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::COPY;
    }
}