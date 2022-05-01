<?php
declare(strict_types=1);

use TaxCore\Request\Copy\CopyRefundCustomer;

$cashier = include __DIR__ . '/data/cashier.php';
$items = include __DIR__ . '/data/items.php';
$payment = include __DIR__ . '/data/advance-payment.php';
$referentDocument = [
    'referentDocumentNumber'   => $_SESSION['kopija–prodaja-sa-identifikacijom.php']['referentDocumentNumber'],
    'referentDocumentDateTime' => $_SESSION['kopija–prodaja-sa-identifikacijom.php']['referentDocumentDateTime']
];
$buyer = include __DIR__ . '/data/buyer.php';

return new CopyRefundCustomer($cashier, $items, $payment, $referentDocument, $buyer);
