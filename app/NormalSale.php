<?php
declare(strict_types=1);

namespace Fiskalizacija;

use Fiskalizacija\Constants\InvoiceType;
use Fiskalizacija\Sale\Sale;

final class NormalSale extends Sale
{

    /**
     * @var int
     */
    protected int $invoiceType = InvoiceType::NORMAL;
}
