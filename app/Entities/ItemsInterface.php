<?php
declare(strict_types=1);

namespace TaxCore\Entities;

interface ItemsInterface
{

    /**
     * @return ItemInterface[]
     */
    public function all(): array;

    /**
     * @return float
     */
    public function amount(): float;
}