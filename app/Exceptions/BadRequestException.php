<?php
declare(strict_types=1);

namespace Fiskalizacija\Exceptions;

use Exception;

final class BadRequestException extends Exception
{

    public function __construct()
    {
        parent::__construct('HTTP client bad request.');
    }
}