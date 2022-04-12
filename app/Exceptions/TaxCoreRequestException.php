<?php
declare(strict_types=1);

namespace TaxCore\Exceptions;

use Exception;

final class TaxCoreRequestException extends Exception
{

    /**
     * @noinspection PhpPureAttributeCanBeAddedInspection
     */
    public function __construct()
    {
        parent::__construct('Tax core returns response status code different then 200.');
    }
}
