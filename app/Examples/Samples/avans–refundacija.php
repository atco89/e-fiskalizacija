<?php
declare(strict_types=1);

use TaxCore\Request\AdvanceSale\AdvanceSaleRefund;

$cashier = include __DIR__ . '/data/cashier.php';
$items = include __DIR__ . '/data/items.php';
$payment = include __DIR__ . '/data/advance-payment.php';
$referentDocument = [
    'referentDocumentNumber'   => $_SESSION['avans–prodaja.php']['referentDocumentNumber'],
    'referentDocumentDateTime' => $_SESSION['avans–prodaja.php']['referentDocumentDateTime']
];

return new AdvanceSaleRefund($cashier, $items, $payment, $referentDocument);
