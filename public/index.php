<?php
declare(strict_types=1);

use TaxCore\Examples\Configuration\Cashier;
use TaxCore\Examples\Configuration\Config;
use TaxCore\Examples\Configuration\Merchant;
use TaxCore\Examples\Request\RequestBuilder;
use TaxCore\Exceptions\TaxCoreRequestException;
use TaxCore\Request;

require_once __DIR__ . '/../vendor/autoload.php';

$sample = include __DIR__ . '/../app/Examples/Samples/promet–prodaja.php';

$merchant = new Merchant();
$cashier = new Cashier();
$config = new Config();

try {
    $builder = new RequestBuilder($merchant, $cashier, $sample);
    $request = new Request($merchant, $config);
    $request->run($builder);
} catch (TaxCoreRequestException $e) {
    die($e->getMessage());
}
