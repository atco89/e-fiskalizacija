<?php
declare(strict_types=1);

namespace TaxCore\Entities;

use DateTime;

interface RequestInterface
{

    /**
     * @return string
     */
    public function requestId(): string;

    /**
     * @return string
     */
    public function invoiceNumber(): string;

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
     * @return string|null
     */
    public function buyerId(): ?string;

    /**
     * @return string|null
     */
    public function buyerCostCenterId(): ?string;

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
     * @return Payment[]
     */
    public function payments(): array;

    /**
     * @return float
     */
    public function amount(): float;
}
