<?php
declare(strict_types=1);

namespace TaxCore\Entities;

interface PrintInterface
{

    /**
     * @return string
     */
    public function title(): string;

    /**
     * @return string
     */
    public function receipt(): string;
}
