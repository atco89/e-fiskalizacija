<?php
declare(strict_types=1);

namespace TaxCore\Entities;

interface Price
{

    /**
     * @return float
     */
    public function tax(): float;

    /**
     * @return float
     */
    public function basis(): float;

    /**
     * @return float
     */
    public function total(): float;
}
