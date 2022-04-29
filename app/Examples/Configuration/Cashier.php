<?php
declare(strict_types=1);

namespace TaxCore\Examples\Configuration;

use TaxCore\Entities\CashierInterface;

final class Cashier implements CashierInterface
{

    /**
     * @return string
     */
    public function id(): string
    {
        return str_pad('1', 10, '0', STR_PAD_LEFT);
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'Петар';
    }

    /**
     * @return string
     */
    public function surname(): string
    {
        return 'Петровић';
    }
}
