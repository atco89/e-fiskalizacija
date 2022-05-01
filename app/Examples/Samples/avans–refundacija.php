<?php
declare(strict_types=1);

use TaxCore\Request\AdvanceSale\AdvanceSaleRefund;

$cashier = include __DIR__ . '/data/cashier.php';
$items = include __DIR__ . '/data/items.php';
$payment = include __DIR__ . '/data/advance-payment.php';
$referentDocument = include __DIR__ . '/data/referent-document.php';

return new AdvanceSaleRefund($cashier, $items, $payment, $referentDocument);
