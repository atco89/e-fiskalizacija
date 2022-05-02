<?php
declare(strict_types=1);

namespace TaxCore\Request;

use TaxCore\Entities\Enums\TransactionType;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;

abstract class Sale extends RequestInterfaceImpl
{

    /**
     * @param string $cashier
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
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
