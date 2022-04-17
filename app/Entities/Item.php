<?php
declare(strict_types=1);

namespace TaxCore\Entities;

interface Item
{

    /**
     * @return int
     */
    public function id(): int;

    /**
     * @return string|null
     */
    public function barcode(): ?string;

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
    public function unitPrice(): float;

    /**
     * @return string[]
     */
    public function labels(): array;

    /**
     * @return float
     */
    public function amount(): float;
}
