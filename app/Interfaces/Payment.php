<?php
declare(strict_types=1);

namespace App\Interfaces;

interface Payment
{

    /**
     * @return float
     */
    public function amount(): float;

    /**
     * @return int
     */
    public function paymentType(): int;
}
