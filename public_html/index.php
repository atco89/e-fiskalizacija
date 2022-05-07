<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use TaxCore\Examples\Configuration;
use TaxCore\Examples\Request\RequestCustomerIdentifiedProperties;
use TaxCore\Examples\Request\RequestCustomerIdentifiedWithCostCenterProperties;
use TaxCore\Examples\Request\RequestSaleProperties;
use TaxCore\Examples\Request\RequestRefundCustomerIdentifiedProperties;
use TaxCore\Examples\Request\RequestRefundProperties;
use TaxCore\Request;
use TaxCore\Response\ResponseBuilder;

$requestProperties = new RequestSaleProperties();
$requestCustomerIdentifiedWithCostCenterProperties = new RequestCustomerIdentifiedWithCostCenterProperties();

try {
    $request = new Request(new Configuration());

//    // ==========================================================================================
//    // NORMAL SALE
//    // ==========================================================================================
//    $r1 = $request->normalSale($requestProperties);
//    save($r1->getResponse()->invoiceNumber(), $r1->getReceipt()->receipt());
//
//    // ==========================================================================================
//    // NORMAL SALE CUSTOMER IDENTIFIED
//    // ==========================================================================================
//    $r2 = $request->normalSaleCustomerIdentified($requestCustomerIdentifiedWithCostCenterProperties);
//    save($r2->getResponse()->invoiceNumber(), $r2->getReceipt()->receipt());
//
//    // ==========================================================================================
//    // NORMAL SALE REFUND
//    // ==========================================================================================
//    $r3 = $request->normalSaleRefund(
//        new RequestRefundProperties($r1->getResponse()->invoiceNumber(), $r1->getResponse()->sdcDateTime())
//    );
//    save($r3->getResponse()->invoiceNumber(), $r3->getReceipt()->receipt());
//
//    // ==========================================================================================
//    // NORMAL SALE CUSTOMER IDENTIFIED REFUND
//    // ==========================================================================================
//    $r4 = $request->normalSaleRefundCustomerIdentified(
//        new RequestRefundCustomerIdentifiedProperties($r2->getResponse()->invoiceNumber(), $r2->getResponse()->sdcDateTime())
//    );
//    save($r4->getResponse()->invoiceNumber(), $r4->getReceipt()->receipt());
//
    // ==========================================================================================
    // ADVANCE SALE
    // ==========================================================================================
    $r5 = $request->advanceSale(new RequestSaleProperties());
    save($r5->getResponse()->invoiceNumber(), $r5->getReceipt()->receipt());
//
//    // ==========================================================================================
//    // ADVANCE SALE CUSTOMER IDENTIFIED
//    // ==========================================================================================
//    $r6 = $request->advanceSaleCustomerIdentified(new RequestCustomerIdentifiedProperties());
//    save($r6->getResponse()->invoiceNumber(), $r6->getReceipt()->receipt());
//
//    // ==========================================================================================
//    // ADVANCE SALE REFUND
//    // ==========================================================================================
//    $r7 = $request->advanceSaleRefund(new RequestRefundProperties(
//        $r5->getResponse()->invoiceNumber(),
//        $r5->getResponse()->sdcDateTime()
//    ));
//    save($r7->getResponse()->invoiceNumber(), $r7->getReceipt()->receipt());
//
//    // ==========================================================================================
//    // ADVANCE SALE CUSTOMER IDENTIFIED REFUND
//    // ==========================================================================================
//    $r7 = $request->advanceSaleRefundCustomerIdentified(new RequestRefundCustomerIdentifiedProperties(
//        $r6->getResponse()->invoiceNumber(),
//        $r6->getResponse()->sdcDateTime()
//    ));
//    save($r7->getResponse()->invoiceNumber(), $r7->getReceipt()->receipt());

    // ==========================================================================================
    // ADVANCE SALE CUSTOMER IDENTIFIED REFUND
    // ==========================================================================================
    $r9 = $request->normalSaleWithClosedAdvanceSaleRequest(
        new RequestRefundProperties($r5->getResponse()->invoiceNumber(), $r5->getResponse()->sdcDateTime()),
        new RequestSaleProperties(),
    );

    /** @var ResponseBuilder $item */
    foreach ($r9 as $item) {
        save($item->getResponse()->invoiceNumber(), $item->getReceipt()->receipt());
    }
} catch (Exception $e) {
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