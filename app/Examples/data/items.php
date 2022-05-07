<?php
declare(strict_types=1);

use TaxCore\Entities\ItemInterface;
use TaxCore\Examples\ItemBuilder;

$items = [
    [
        'gtin'      => '9002490100070',
        'name'      => 'Energetski napitak Red Bull limen.0,25l',
        'quantity'  => 3.00,
        'unitPrice' => 149.99,
        'labels'    => ['Ж'],
    ],
    [
        'gtin'      => '5449000214911',
        'name'      => 'Coca-Cola limenka 0,33l',
        'quantity'  => 4.00,
        'unitPrice' => 62.99,
        'labels'    => ['A'],
    ],
    [
        'gtin'      => '5290047000117',
        'name'      => 'Pepsi limenka 0,33l',
        'quantity'  => 5.00,
        'unitPrice' => 55.99,
        'labels'    => ['B'],
    ],
];

return array_map(function (array $item): ItemInterface {
    return new ItemBuilder($item);
}, $items);
