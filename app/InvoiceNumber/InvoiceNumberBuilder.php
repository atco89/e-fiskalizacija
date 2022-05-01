<?php
declare(strict_types=1);

namespace TaxCore\InvoiceNumber;

use DateTime;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\Enums\TransactionType;

final class InvoiceNumberBuilder
{

    /**
     * @const int
     */
    const LENGTH = 10;

    /**
     * @var InvoiceType
     */
    private InvoiceType $invoiceType;

    /**
     * @var TransactionType
     */
    private TransactionType $transactionType;

    /**
     * @var DateTime
     */
    private DateTime $issueDateTime;

    /**
     * @param InvoiceType $invoiceType
     * @param TransactionType $transactionType
     * @param DateTime $issueDateTime
     */
    public function __construct(InvoiceType $invoiceType, TransactionType $transactionType, DateTime $issueDateTime)
    {
        $this->invoiceType = $invoiceType;
        $this->transactionType = $transactionType;
        $this->issueDateTime = $issueDateTime;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return implode('-', [$this->receiptType(), $this->number(), $this->issueYear()]);
    }

    /**
     * @return string
     */
    private function receiptType(): string
    {
        $invoiceType = strtoupper(substr($this->invoiceType->name, 0, 1));
        $transactionType = strtoupper(substr($this->transactionType->name, 0, 1));
        return implode('', [$invoiceType, $transactionType]);
    }

    /**
     * @return string
     */
    private function number(): string
    {
        return str_pad(strval(1), self::LENGTH, '0', STR_PAD_LEFT);
    }

    /**
     * @return string
     */
    private function issueYear(): string
    {
        return $this->issueDateTime->format('y');
    }
}