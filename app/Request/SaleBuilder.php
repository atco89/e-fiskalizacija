<?php
declare(strict_types=1);

namespace TaxCore\Request;

use TaxCore\Entities\Enums\TransactionType;

abstract class SaleBuilder extends ApiRequestBase
{

    /**
     * @return TransactionType
     */
    public function transactionType(): TransactionType
    {
        return TransactionType::SALE;
    }
}
