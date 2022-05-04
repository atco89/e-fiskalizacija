<?php
declare(strict_types=1);

namespace TaxCore\Request;

use DateTime;
use DateTimeInterface;
use Ramsey\Uuid\Uuid;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;
use TaxCore\Entities\RequestInterface;

abstract class RequestBase implements RequestInterface
{

    /**
     * @var string
     */
    private string $cashier;

    /**
     * @var string
     */
    private string $invoiceNumber;

    /**
     * @var ItemInterface[]
     */
    private array $items;

    /**
     * @var PaymentTypeInterface[]
     */
    private array $payment;

    /**
     * @var DateTimeInterface
     */
    private DateTimeInterface $issueDateTime;

    /**
     * @var string
     */
    private string $requestId;

    /**
     * @param string $cashier
     * @param string $invoiceNumber
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     */
    public function __construct(string $cashier, string $invoiceNumber, array $items, array $payment)
    {
        $this->cashier = $cashier;
        $this->invoiceNumber = $invoiceNumber;
        $this->items = $items;
        $this->payment = $payment;
        $this->issueDateTime = $this->generateIssueDateTime();
        $this->requestId = $this->generateRequestId();
    }

    /**
     * @return DateTimeInterface
     */
    private function generateIssueDateTime(): DateTimeInterface
    {
        return new DateTime();
    }

    /**
     * @return string
     */
    private function generateRequestId(): string
    {
        return Uuid::uuid4()->toString();
    }

    /**
     * @return string
     */
    final public function invoiceNumber(): string
    {
        return $this->invoiceNumber;
    }

    /**
     * @return DateTimeInterface
     */
    final public function issueDateTime(): DateTimeInterface
    {
        return $this->issueDateTime;
    }

    /**
     * @return string
     */
    final public function cashier(): string
    {
        return $this->cashier;
    }

    /**
     * @return array
     */
    final public function items(): array
    {
        return $this->items;
    }

    /**
     * @return array
     */
    final public function payments(): array
    {
        return $this->payment;
    }

    /**
     * @return string
     */
    final public function requestId(): string
    {
        return $this->requestId;
    }

    /**
     * @return float
     */
    final public function amount(): float
    {
        return array_reduce($this->items, function (float|null $carry, ItemInterface $item): float {
            $carry += $item->amount();
            return $carry;
        });
    }
}
