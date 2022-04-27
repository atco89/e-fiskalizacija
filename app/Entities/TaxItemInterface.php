<?php
declare(strict_types=1);

namespace TaxCore\Entities;

interface TaxItemInterface
{

    /**
     * @return string
     */
    public function label(): string;

    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return int
     */
    public function type(): int;

    /**
     * @return float
     */
    public function rate(): float;

    /**
     * @return float
     */
    public function amount(): float;
}
