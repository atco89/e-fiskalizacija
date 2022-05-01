<?php
declare(strict_types=1);

use TaxCore\Request\NormalSale;

$items = include __DIR__ . '/data/items.php';
$payment = include __DIR__ . '/data/payment.php';
$cashier = include __DIR__ . '/data/cashier.php';

return new NormalSale($cashier, $items, $payment);
