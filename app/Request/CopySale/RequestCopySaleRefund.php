<?php
declare(strict_types=1);

namespace TaxCore\Request\CopySale;

use TaxCore\Entities\CustomerSignatureInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Request\RefundBuilder;

final class RequestCopySaleRefund extends RefundBuilder implements CustomerSignatureInterface
{

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::COPY;
    }
}