<?php
declare(strict_types=1);

namespace App;

use App\Constants\InvoiceType;
use App\Sale\Sale;

final class NormalSale extends Sale
{

    /**
     * @var int
     */
    protected int $invoiceType = InvoiceType::NORMAL;
}
