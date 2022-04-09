<?php
declare(strict_types=1);

namespace Fiskalizacija\Domain;

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
}
