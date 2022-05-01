<?php
declare(strict_types=1);

use TaxCore\Examples\Configuration\Configuration;
use TaxCore\Exceptions\TaxCoreRequestException;
use TaxCore\Request;

require_once __DIR__ . '/../vendor/autoload.php';

$configuration = new Configuration();
try {
    $requestBuilder = include __DIR__ . '/../app/Examples/Samples/avans–prodaja-sa-identifikacijom.php';

    $request = new Request($configuration);
    $responseBuilder = $request->run($requestBuilder);

    die($responseBuilder->getReceipt());
} catch (TaxCoreRequestException | Error | Exception $e) {
    die($e->getMessage());
}
