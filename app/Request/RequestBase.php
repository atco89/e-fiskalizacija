<?php
declare(strict_types=1);

namespace TaxCore\Request;

use DateTimeInterface;
use Ramsey\Uuid\Uuid;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;
use TaxCore\Entities\Properties\RequestPropertiesInterface;
use TaxCore\Entities\RequestInterface;

abstract class RequestBase implements RequestInterface
{

    /**
     * @var array
     */
    protected array $items;

    /**
     * @var array
     */
    protected array $payment;

    /**
     * @var float
     */
    protected float $amount;

    /**
     * @var string
     */
    protected string $requestId;

    /**
     * @param RequestPropertiesInterface $properties
     */
    public function __construct(RequestPropertiesInterface $properties)
    {
        $this->items = $properties->items();
        $this->payment = $properties->payment();
        $this->amount = $this->sumItemsAmount($this->items);
        $this->requestId = $this->generateRequestId();
    }

    /**
     * @param array $items
     * @return float
     */
    private function sumItemsAmount(array $items): float
    {
        return array_reduce($items, function (float|null $carry, ItemInterface $item): float {
            $carry += $item->amount();
            return $carry;
        });
    }

    /**
     * @return string
     */
    private function generateRequestId(): string
    {
        return Uuid::uuid4()->toString();
    }

    /**
     * @return DateTimeInterface|null
     */
    public function issueDateTime(): DateTimeInterface|null
    {
        return null;
    }

    /**
     * @return string
     */
    final public function requestId(): string
    {
        return $this->requestId;
    }

    /**
     * @return ItemInterface[]
     */
    public function items(): array
    {
        return $this->items;
    }

    /**
     * @return PaymentTypeInterface[]
     */
    final public function payments(): array
    {
        return $this->payment;
    }

    /**
     * @return float
     */
    final public function amount(): float
    {
        return $this->amount;
    }

    /**
     * @return array|null
     */
    public function advertisementItems(): array|null
    {
        return null;
    }
}
