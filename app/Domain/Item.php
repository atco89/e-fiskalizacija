<?php
declare(strict_types=1);

namespace Fiskalizacija\Domain;

interface Item
{

    /**
     * @return string|null
     */
    public function globalTradeItemNumber(): ?string;

    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return float
     */
    public function quantity(): float;

    /**
     * @return float
     */
    public function price(): float;

    /**
     * @return string[]
     */
    public function labels(): array;

    /**
     * @return float
     */
    public function amount(): float;
}
