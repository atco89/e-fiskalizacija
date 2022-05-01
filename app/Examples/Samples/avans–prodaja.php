<?php
declare(strict_types=1);

use TaxCore\Request\AdvanceSale;

$items = include __DIR__ . '/data/items.php';
$payment = include __DIR__ . '/data/advance-payment.php';
$cashier = include __DIR__ . '/data/cashier.php';

return new AdvanceSale($cashier, $items, $payment);
