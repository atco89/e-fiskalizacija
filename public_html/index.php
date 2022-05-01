<?php
declare(strict_types=1);

use TaxCore\Examples\Configuration\Configuration;
use TaxCore\Exceptions\TaxCoreRequestException;
use TaxCore\Request;

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

$samples = [
    'promet–prodaja.php',
    'promet–prodaja-sa-identifikacijom.php',

    'avans–prodaja.php',
    'avans–prodaja-sa-identifikacijom.php',

    'kopija–prodaja.php',
    'kopija–prodaja-sa-identifikacijom.php',

    'promet–refundacija.php',
    'promet–refundacija-sa-identifikacijom.php',

    'avans–refundacija.php',
    'avans–refundacija-sa-identifikacijom.php',

    'kopija–refundacija.php',
    'kopija–refundacija-sa-identifikacijom.php',
];

$configuration = new Configuration();
try {
    $request = new Request($configuration);
    foreach ($samples as $sample) {
        /** @noinspection PhpIncludeInspection */
        $requestBuilder = include __DIR__ . "/../app/Examples/Samples/$sample";
        $responseBuilder = $request->run($requestBuilder);

        $response = $responseBuilder->getResponse();
        $_SESSION[$sample]['referentDocumentNumber'] = $response->invoiceNumber();
        $_SESSION[$sample]['referentDocumentDateTime'] = $response->sdcDateTime()->format(DATE_ISO8601);

        $file = fopen(__DIR__ . "/../resources/output/{$_SESSION[$sample]['referentDocumentNumber']}.html", 'w');
        fwrite($file, $responseBuilder->getReceipt());
        fclose($file);

        sleep(30);
    }
    session_destroy();
} catch (TaxCoreRequestException | Error | Exception $e) {
    die($e->getMessage());
}
