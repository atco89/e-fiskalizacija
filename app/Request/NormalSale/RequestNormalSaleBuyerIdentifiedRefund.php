<?php
declare(strict_types=1);

namespace TaxCore\Request\NormalSale;

use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Request\RefundBuyerIdentifiedBuilder;

final class RequestNormalSaleBuyerIdentifiedRefund extends RefundBuyerIdentifiedBuilder
{

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::NORMAL;
    }
}
