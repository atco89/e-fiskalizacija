<?php
declare(strict_types=1);

namespace TaxCore\Entities;

interface ItemInterface
{

    /**
     * @return string|null
     */
    public function gtin(): string|null;

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
     * @return array
     */
    public function labels(): array;

    /**
     * @return float
     */
    public function amount(): float;
}
