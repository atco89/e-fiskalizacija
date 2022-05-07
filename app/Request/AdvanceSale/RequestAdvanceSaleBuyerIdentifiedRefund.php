<?php
declare(strict_types=1);

namespace TaxCore\Request\AdvanceSale;

use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Request\RefundBuyerIdentifiedBuilder;

final class RequestAdvanceSaleBuyerIdentifiedRefund extends RefundBuyerIdentifiedBuilder
{

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::ADVANCE;
    }
}
