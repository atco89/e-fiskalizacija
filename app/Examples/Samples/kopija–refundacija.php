<?php
declare(strict_types=1);

use TaxCore\Request\Copy\CopyRefund;

$cashier = include __DIR__ . '/data/cashier.php';
$items = include __DIR__ . '/data/items.php';
$payment = include __DIR__ . '/data/advance-payment.php';
$referentDocument = [
    'referentDocumentNumber'   => $_SESSION['kopija–prodaja.php']['referentDocumentNumber'],
    'referentDocumentDateTime' => $_SESSION['kopija–prodaja.php']['referentDocumentDateTime']
];

return new CopyRefund($cashier, $items, $payment, $referentDocument);
