<?php
declare(strict_types=1);

use TaxCore\Entities\Enums\PaymentType;
use TaxCore\Entities\PaymentTypeInterface;
use TaxCore\Examples\Payment;

$paymentItems = [
    [
        'type'   => PaymentType::CARD,
        'amount' => 500.00,
    ],
];

return array_map(function (array $item): PaymentTypeInterface {
    return new Payment($item);
}, $paymentItems);
