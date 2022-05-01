<?php
declare(strict_types=1);

use TaxCore\Request\NormalSale\NormalSaleCustomer;

$cashier = include __DIR__ . '/data/cashier.php';
$items = include __DIR__ . '/data/items.php';
$payment = include __DIR__ . '/data/payment.php';
$buyer = include __DIR__ . '/data/buyer.php';

return new NormalSaleCustomer($cashier, $items, $payment, $buyer);
