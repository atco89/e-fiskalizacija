<?php
declare(strict_types=1);

namespace TaxCore\Request\NormalSale;

use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Request\RefundCustomerIdentified;

final class NormalSaleRefundCustomerIdentifiedRequest extends RefundCustomerIdentified
{

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::NORMAL;
    }
}
