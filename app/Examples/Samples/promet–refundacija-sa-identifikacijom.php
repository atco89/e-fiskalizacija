<?php
declare(strict_types=1);

use TaxCore\Request\NormalSale\NormalSaleCustomerRefund;

$cashier = include __DIR__ . '/data/cashier.php';
$items = include __DIR__ . '/data/items.php';
$payment = include __DIR__ . '/data/payment.php';
$referentDocument = include __DIR__ . '/data/referent-document.php';
$buyer = include __DIR__ . '/data/buyer.php';

return new NormalSaleCustomerRefund($cashier, $items, $payment, $referentDocument, $buyer);
