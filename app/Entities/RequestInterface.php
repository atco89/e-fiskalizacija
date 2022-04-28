<?php
declare(strict_types=1);

namespace TaxCore\Entities;

use DateTime;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\Enums\TransactionType;

interface RequestInterface
{

    /**
     * @return MerchantInterface
     */
    public function merchant(): MerchantInterface;

    /**
     * @return CashierInterface
     */
    public function cashier(): CashierInterface;

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
     * @return string|null
     */
    public function buyerId(): string|null;

    /**
     * @return string|null
     */
    public function buyerCostCenterId(): string|null;

    /**
     * @return string|null
     */
    public function referentDocumentNumber(): string|null;

    /**
     * @return DateTime|null
     */
    public function referentDocumentDateTime(): DateTime|null;

    /**
     * @return ItemsInterface
     */
    public function items(): ItemsInterface;

    /**
     * @return PaymentInterface
     */
    public function payments(): PaymentInterface;

    /**
     * @return float
     */
    public function amount(): float;

    /**
     * @return bool
     */
    public function omitQRCodeGen(): bool;

    /**
     * @return bool
     */
    public function omitTextualRepresentation(): bool;
}
