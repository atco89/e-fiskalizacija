<?php
declare(strict_types=1);

namespace TaxCore\Request\NormalSale;

use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Request\SaleBuilder;

final class RequestNormalSale extends SaleBuilder
{

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::NORMAL;
    }
}
