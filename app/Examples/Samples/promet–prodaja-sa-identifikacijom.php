<?php
declare(strict_types=1);

use TaxCore\Request\NormalSaleCustomerIdentified;

$items = include __DIR__ . '/data/items.php';
$payment = include __DIR__ . '/data/payment.php';
$buyer = include __DIR__ . '/data/buyer.php';
$cashier = include __DIR__ . '/data/cashier.php';

return new NormalSaleCustomerIdentified($cashier, $items, $payment, $buyer);
