<?php
declare(strict_types=1);

namespace TaxCore\Entities;

interface AdvertisementItemInterface
{

    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return float|null
     */
    public function amount(): float|null;
}
