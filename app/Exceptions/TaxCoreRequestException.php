<?php
declare(strict_types=1);

namespace TaxCore\Exceptions;

use Exception;

final class TaxCoreRequestException extends Exception
{

    /**
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
