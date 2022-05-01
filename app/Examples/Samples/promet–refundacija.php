<?php
declare(strict_types=1);

use TaxCore\Request\NormalSale\NormalSaleRefund;

$cashier = include __DIR__ . '/data/cashier.php';
$items = include __DIR__ . '/data/items.php';
$payment = include __DIR__ . '/data/payment.php';
$referentDocument = include __DIR__ . '/data/referent-document.php';

return new NormalSaleRefund($cashier, $items, $payment, $referentDocument);
