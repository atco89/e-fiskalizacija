<?php

namespace TaxCore\Request;

use TaxCore\Entities\Enums\TransactionType;

abstract class Sale extends CommonRequest
{

    /**
     * @param string $cashier
     * @param array $items
     * @param array $payment
     */
    public function __construct(string $cashier, array $items, array $payment)
    {
        parent::__construct($cashier, $items, $payment);
    }

    /**
     * @return TransactionType
     */
    public function transactionType(): TransactionType
    {
        return TransactionType::SALE;
    }
}
