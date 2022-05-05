<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use TaxCore\Examples\Configuration;
use TaxCore\Exceptions\TaxCoreRequestException;
use TaxCore\Request;

$cashier = 'Petar Petrović';
$buyer = include __DIR__ . '/../app/Examples/data/buyer.php';
$items = include __DIR__ . '/../app/Examples/data/items.php';
$payment = include __DIR__ . '/../app/Examples/data/payment.php';
$refundPayment = include __DIR__ . '/../app/Examples/data/payment-refund.php';
$advancePayment = include __DIR__ . '/../app/Examples/data/advance-payment.php';
$refDocument = include __DIR__ . '/../app/Examples/data/referent-document.php';

try {
    $request = new Request(new Configuration());
//    $responseBuilder = $request->advanceSale($cashier, $items, $advancePayment);
//    $responseBuilder = $request->advanceSaleCustomerIdentified($cashier, $items, $advancePayment, $buyer);
//    $responseBuilder = $request->advanceSaleRefund($cashier, $items, $advancePayment, $refDocument);
    $responseBuilder = $request->advanceSaleRefundCustomerIdentified($cashier, $items, $advancePayment, $refDocument, $buyer);
    die($responseBuilder->getReceipt()->receipt());
} catch (TaxCoreRequestException $e) {
    die($e->getMessage());
}
