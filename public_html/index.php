<?php
declare(strict_types=1);

use TaxCore\Examples\Configuration\Cashier;
use TaxCore\Examples\Configuration\Configuration;
use TaxCore\Examples\Configuration\Merchant;
use TaxCore\Examples\Request\RequestBuilder;
use TaxCore\Exceptions\TaxCoreRequestException;
use TaxCore\Request;

require_once __DIR__ . '/../vendor/autoload.php';

$merchant = new Merchant();
try {
    $parsedBody = include __DIR__ . '/../app/Examples/Samples/promet–prodaja.php';

    $request = new Request(new Configuration());
    $responseBuilder = $request->run(new RequestBuilder($merchant, new Cashier(), $parsedBody));

    die($responseBuilder->getReceipt());
} catch (TaxCoreRequestException | Error | Exception $e) {
    die($e->getMessage());
}
