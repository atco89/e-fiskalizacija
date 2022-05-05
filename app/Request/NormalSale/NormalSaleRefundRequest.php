<?php
declare(strict_types=1);

namespace TaxCore\Request\NormalSale;

use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Request\Refund;

final class NormalSaleRefundRequest extends Refund
{

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::NORMAL;
    }
}
