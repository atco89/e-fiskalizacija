<?php
declare(strict_types=1);

namespace TaxCore\Entities;

interface CashierInterface
{

    /**
     * @return string
     */
    public function id(): string;

    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return string
     */
    public function surname(): string;
}
