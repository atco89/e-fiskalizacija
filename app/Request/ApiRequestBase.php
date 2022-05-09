<?php
declare(strict_types=1);

namespace TaxCore\Request;

use DateTimeInterface;
use Ramsey\Uuid\Uuid;
use TaxCore\Entities\ApiRequestInterface;
use TaxCore\Entities\ItemInterface;

abstract class ApiRequestBase implements ApiRequestInterface
{

    /**
     * @var array
     */
    protected array $items;

    /**
     * @var float
     */
    protected float $amount;

    /**
     * @var string
     */
    protected string $requestId;

    /**
     * @param ItemInterface[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
        $this->amount = $this->sumItemsAmount($this->items());
        $this->requestId = $this->generateRequestId();
    }

    /**
     * @param ItemInterface[] $items
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
     * @return ItemInterface[]
     */
    public function items(): array
    {
        return $this->items;
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
