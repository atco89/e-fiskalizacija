<?php
declare(strict_types=1);

use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\Enums\PaymentType;
use TaxCore\Entities\Enums\TransactionType;

$sampleFileName = basename(__FILE__, '.php');
return [
    'invoiceType'              => InvoiceType::COPY,
    'transactionType'          => TransactionType::SALE,
    'buyerId'                  => null,
    'buyerCostCenterId'        => null,
    'referentDocumentNumber'   => $_SESSION['promet–prodaja']['refDocumentNumber'],
    'referentDocumentDateTime' => unserialize($_SESSION['promet–prodaja']['refDocumentDateTime']),
    'items'                    => [
        [
            'gtin'      => '9002490100070',
            'name'      => 'Energetski napitak Red Bull limen.0,25l',
            'quantity'  => 4,
            'unitPrice' => 149.99,
            'labels'    => 'Ж',
        ],
        [
            'gtin'      => '5449000214911',
            'name'      => 'Coca-Cola limenka 0,33l',
            'quantity'  => 3,
            'unitPrice' => 62.99,
            'labels'    => 'Ж',
        ],
        [
            'gtin'      => '5290047000117',
            'name'      => 'Pepsi limenka 0,33l',
            'quantity'  => 5,
            'unitPrice' => 55.99,
            'labels'    => 'Ж',
        ],
    ],
    'advanceAccount'           => null,
    'payment'                  => [
        [
            'type'   => PaymentType::CASH,
            'amount' => 500.00,
        ],
        [
            'type'   => PaymentType::CARD,
            'amount' => 568.88,
        ],
    ],
];