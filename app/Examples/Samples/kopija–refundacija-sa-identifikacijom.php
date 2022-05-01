<?php
declare(strict_types=1);

use TaxCore\Request\Copy\CopyRefundCustomer;

$cashier = include __DIR__ . '/data/cashier.php';
$items = include __DIR__ . '/data/items.php';
$payment = include __DIR__ . '/data/advance-payment.php';
$referentDocument = include __DIR__ . '/data/referent-document.php';
$buyer = include __DIR__ . '/data/buyer.php';

return new CopyRefundCustomer($cashier, $items, $payment, $referentDocument, $buyer);
