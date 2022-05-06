<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use TaxCore\Examples\Configuration;
use TaxCore\Examples\Request\RequestCustomerIdentifiedWithCostCenterProperties;
use TaxCore\Examples\Request\RequestProperties;
use TaxCore\Exceptions\TaxCoreRequestException;
use TaxCore\Request;

$requestProperties = new RequestProperties();
$requestCustomerIdentifiedWithCostCenterProperties = new RequestCustomerIdentifiedWithCostCenterProperties();

try {
    $request = new Request(new Configuration());

    // ==========================================================================================
    // NORMAL SALE
    // ==========================================================================================
    $r1 = $request->normalSale($requestProperties);
    save($r1->getResponse()->invoiceNumber(), $r1->getReceipt()->receipt());

    // ==========================================================================================
    // NORMAL SALE CUSTOMER IDENTIFIED
    // ==========================================================================================
    $r2 = $request->normalSaleCustomerIdentified($requestCustomerIdentifiedWithCostCenterProperties);
    save($r2->getResponse()->invoiceNumber(), $r2->getReceipt()->receipt());

} catch (TaxCoreRequestException $e) {
    die($e->getMessage());
}

/**
 * @param string $invoiceNumber
 * @param string $receipt
 */
function save(string $invoiceNumber, string $receipt): void
{
    $file = fopen(__DIR__ . "/../resources/output/$invoiceNumber.html", 'w');
    fwrite($file, $receipt);
    fclose($file);
}