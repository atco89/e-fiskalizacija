<?php
declare(strict_types=1);

namespace App\Constants;

interface InvoiceType
{

    /**
     * @const int
     */
    const NORMAL = 0;

    /**
     * @const int
     */
    const PROFORMA = 1;

    /**
     * @const int
     */
    const COPY = 2;

    /**
     * @const int
     */
    const TRAINING = 3;

    /**
     * @const int
     */
    const ADVANCE = 4;
}
