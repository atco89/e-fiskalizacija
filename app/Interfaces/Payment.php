<?php
declare(strict_types=1);

namespace Fiskalizacija\Interfaces;

interface Payment
{

    /**
     * @return float
     */
    public function amount(): float;

    /**
     * @return int
     */
    public function type(): int;

    /**
     * @return string
     */
    public function name(): string;
}
