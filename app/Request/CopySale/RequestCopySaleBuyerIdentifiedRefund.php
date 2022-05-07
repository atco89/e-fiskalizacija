<?php
declare(strict_types=1);

namespace TaxCore\Request\CopySale;

use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Request\RefundBuyerIdentifiedBuilder;

final class RequestCopySaleBuyerIdentifiedRefund extends RefundBuyerIdentifiedBuilder
{

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::COPY;
    }
}
