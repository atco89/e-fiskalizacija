<?php
declare(strict_types=1);

namespace TaxCore\Entities;

use DateTime;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\Enums\TransactionType;

interface Invoice
{

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
    public function buyerId(): ?string;

    /**
     * @return string|null
     */
    public function buyerCostCenterId(): ?string;

    /**
     * @return string|null
     */
    public function referentDocumentNumber(): ?string;

    /**
     * @return DateTime|null
     */
    public function referentDocumentDateTime(): ?DateTime;
}