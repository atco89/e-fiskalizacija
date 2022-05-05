<?php
declare(strict_types=1);

use TaxCore\Entities\Enums\PaymentType;
use TaxCore\Entities\PaymentTypeInterface;
use TaxCore\Examples\Payment;

$paymentItems = [
    [
        'type'   => PaymentType::CASH,
        'amount' => 981.88,
    ],
];

return array_map(function (array $item): PaymentTypeInterface {
    return new Payment($item);
}, $paymentItems);