<?php
declare(strict_types=1);

use TaxCore\Entities\Enums\TaxRateLabel;
use TaxCore\Examples\AdvanceSaleItemInterfaceBuilder;

$advanceSaleItems = [
    [
        'taxRateLabel' => TaxRateLabel::TL10,
        'amount'       => 230.00,
    ],
    [
        'taxRateLabel' => TaxRateLabel::TL11,
        'amount'       => 130.00,
    ],
    [
        'taxRateLabel' => TaxRateLabel::TL12,
        'amount'       => 140.00,
    ],
];

return array_map(function (array $item) {
    return new AdvanceSaleItemInterfaceBuilder($item);
}, $advanceSaleItems);
