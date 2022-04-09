<?php
declare(strict_types=1);

namespace Fiskalizacija\Domain;

interface TaxItem
{

    /**
     * @return string
     */
    public function label(): string;

    /**
     * @return string
     */
    public function categoryName(): string;

    /**
     * @return int
     */
    public function categoryType(): int;

    /**
     * @return float
     */
    public function rate(): float;

    /**
     * @return float
     */
    public function amount(): float;
}
