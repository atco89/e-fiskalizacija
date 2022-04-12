<?php
declare(strict_types=1);

namespace TaxCore\Exceptions;

use Exception;

final class PaymentTypeNotFoundException extends Exception
{

    /**
     * @noinspection PhpPureAttributeCanBeAddedInspection
     */
    public function __construct()
    {
        parent::__construct('Payment type not found.');
    }
}