<?php
declare(strict_types=1);

use TaxCore\Entities\Enums\PaymentType;
use TaxCore\Entities\PaymentTypeInterface;
use TaxCore\Examples\PaymentBuilder;

$paymentItems = [
    [
        'type'   => PaymentType::CASH,
        'amount' => 500.00,
    ],
];

return array_map(function (array $item): PaymentTypeInterface {
    return new PaymentBuilder($item);
}, $paymentItems);
