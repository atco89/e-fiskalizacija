<?php
declare(strict_types=1);

use TaxCore\Request\NormalSale\NormalSale;

$cashier = include __DIR__ . '/data/cashier.php';
$items = include __DIR__ . '/data/items.php';
$payment = include __DIR__ . '/data/payment.php';

return new NormalSale($cashier, $items, $payment);
