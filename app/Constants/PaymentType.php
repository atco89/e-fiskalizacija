<?php
declare(strict_types=1);

namespace Fiskalizacija\Constants;

interface PaymentType
{

    /**
     * @const int
     */
    const OTHER = 0;

    /**
     * @const int
     */
    const CASH = 1;

    /**
     * @const int
     */
    const CARD = 2;

    /**
     * @const int
     */
    const CHECK = 3;

    /**
     * @const int
     */
    const WIRE_TRANSFER = 4;

    /**
     * @const int
     */
    const VOUCHER = 5;

    /**
     * @const int
     */
    const MOBILE_MONEY = 6;
}
