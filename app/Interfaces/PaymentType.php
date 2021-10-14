<?php
declare(strict_types=1);

namespace Fiskalizacija\Interfaces;

interface PaymentType
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
