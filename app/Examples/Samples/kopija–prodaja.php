<?php
declare(strict_types=1);

use TaxCore\Request\Copy\CopySale;

$cashier = include __DIR__ . '/data/cashier.php';
$items = include __DIR__ . '/data/items.php';
$payment = include __DIR__ . '/data/payment.php';
$referentDocument = [
    'referentDocumentNumber'   => $_SESSION['promet–prodaja.php']['referentDocumentNumber'],
    'referentDocumentDateTime' => $_SESSION['promet–prodaja.php']['referentDocumentDateTime']
];

return new CopySale($cashier, $items, $payment, $referentDocument);
