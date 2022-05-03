<?php
declare(strict_types=1);

namespace TaxCore\Request;

use TaxCore\Entities\Enums\TransactionType;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;

abstract class Sale extends RequestBase
{

    /**
     * @param string $cashier
     * @param string $invoiceNumber
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     */
    public function __construct(string $cashier, string $invoiceNumber, array $items, array $payment)
    {
        parent::__construct($cashier, $invoiceNumber, $items, $payment);
    }

    /**
     * @return TransactionType
     */
    final public function transactionType(): TransactionType
    {
        return TransactionType::SALE;
    }
}
