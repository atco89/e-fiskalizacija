<?php
declare(strict_types=1);

namespace TaxCore\Entities;

use DateTimeInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\Enums\TransactionType;

interface ApiRequestInterface
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
     * @return DateTimeInterface|null
     */
    public function issueDateTime(): DateTimeInterface|null;

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
    public function payment(): array;

    /**
     * @return float
     */
    public function amount(): float;

    /**
     * @return AdvertisementItemInterface[]|null
     */
    public function advertisementItems(): array|null;
}
