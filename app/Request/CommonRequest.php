<?php
declare(strict_types=1);

namespace TaxCore\Request;

use DateTime;
use Ramsey\Uuid\Uuid;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;
use TaxCore\Entities\RequestInterface;
use TaxCore\InvoiceNumber\InvoiceNumberBuilder;

abstract class CommonRequest implements RequestInterface
{

    /**
     * @var string
     */
    private string $cashier;

    /**
     * @var ItemInterface[]
     */
    private array $items;

    /**
     * @var PaymentTypeInterface[]
     */
    private array $payment;

    /**
     * @var DateTime
     */
    private DateTime $issueDateTime;

    /**
     * @var string
     */
    private string $requestId;

    /**
     * @param string $cashier
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     */
    public function __construct(string $cashier, array $items, array $payment)
    {
        $this->cashier = $cashier;
        $this->items = $items;
        $this->payment = $payment;
        $this->issueDateTime = new DateTime();
        $this->requestId = Uuid::uuid4()->toString();
    }

    /**
     * @return string
     */
    final public function invoiceNumber(): string
    {
        $invoiceNumberBuilder = new InvoiceNumberBuilder(
            $this->invoiceType(),
            $this->transactionType(),
            $this->issueDateTime()
        );
        return $invoiceNumberBuilder->get();
    }

    /**
     * @return DateTime
     */
    final public function issueDateTime(): DateTime
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
