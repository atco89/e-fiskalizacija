<?php
declare(strict_types=1);

use TaxCore\Request\AdvanceSale\AdvanceSale;

$cashier = include __DIR__ . '/data/cashier.php';
$items = include __DIR__ . '/data/items.php';
$payment = include __DIR__ . '/data/advance-payment.php';

return new AdvanceSale($cashier, $items, $payment);
