<?php
declare(strict_types=1);

namespace TaxCore\Request\CopySale;

use TaxCore\Entities\CustomerSignatureInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Request\RefundBuyerIdentifiedBuilder;

final class RequestCopySaleBuyerIdentifiedRefund extends RefundBuyerIdentifiedBuilder
    implements CustomerSignatureInterface
{

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::COPY;
    }
}
