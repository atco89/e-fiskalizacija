<?php
declare(strict_types=1);

namespace Fiskalizacija\Domain;

use DateTime;

interface Invoice
{

    /**
     * @return string
     */
    public function requestId(): string;

    /**
     * @return string
     */
    public function number(): string;

    /**
     * @return DateTime
     */
    public function issueDateTime(): DateTime;

    /**
     * @return string|null
     */
    public function referentDocumentNumber(): ?string;

    /**
     * @return DateTime|null
     */
    public function referentDocumentDateTime(): ?DateTime;

    /**
     * @return Merchant
     */
    public function merchant(): Merchant;

    /**
     * @return Cashier
     */
    public function cashier(): Cashier;

    /**
     * @return Item[]
     */
    public function items(): array;

    /**
     * @return float
     */
    public function amount(): float;

    /**
     * @return Payment[]
     */
    public function paymentTypes(): array;

    /**
     * @return TaxItem[]
     */
    public function taxRates(): array;

    /**
     * @return float
     */
    public function taxAmount(): float;
}
