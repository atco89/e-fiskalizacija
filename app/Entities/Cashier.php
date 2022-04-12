<?php
declare(strict_types=1);

namespace TaxCore\Entities;

interface Cashier
{

    /**
     * @return string
     */
    public function identifier(): string;

    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return string
     */
    public function surname(): string;
}