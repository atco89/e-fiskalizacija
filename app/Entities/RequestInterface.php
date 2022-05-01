<?php
declare(strict_types=1);

namespace TaxCore\Entities;

use DateTime;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\Enums\TransactionType;

interface RequestInterface
{

    /**
     * @return string
     */
    public function cashier(): string;

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType;

    /**
     * @return TransactionType
     */
    public function transactionType(): TransactionType;

    /**
     * @return DateTime
     */
    public function issueDateTime(): DateTime;

    /**
     * @return string
     */
    public function invoiceNumber(): string;

    /**
     * @return string
     */
    public function requestId(): string;

    /**
     * @return ItemInterface[]
     */
    public function items(): array;

    /**
     * @return PaymentTypeInterface[]
     */
    public function payments(): array;

    /**
     * @return float
     */
    public function amount(): float;
}
