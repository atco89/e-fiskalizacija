<?php
declare(strict_types=1);

namespace TaxCore\Request;

use DateTime;
use DateTimeInterface;
use Ramsey\Uuid\Uuid;
use TaxCore\Entities\AdvanceSaleAmountInterface;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;
use TaxCore\Entities\RequestInterface;

abstract class RequestBase implements RequestInterface
{

    /**
     * @var string
     */
    protected string $cashier;

    /**
     * @var ItemInterface[]
     */
    protected array $items;

    /**
     * @var PaymentTypeInterface[]
     */
    protected array $payment;

    /**
     * @var DateTimeInterface
     */
    protected DateTimeInterface $issueDateTime;

    /**
     * @var string
     */
    protected string $requestId;

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
     * @return ItemInterface[]
     */
    public function items(): array
    {
        return $this->items;
    }

    /**
     * @return array|null
     */
    public function advertisementItems(): array|null
    {
        return null;
    }

    /**
     * @return PaymentTypeInterface[]
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

    /**
     * @return AdvanceSaleAmountInterface|null
     */
    public function advanceSaleAmountInterface(): AdvanceSaleAmountInterface|null
    {
        return null;
    }
}
