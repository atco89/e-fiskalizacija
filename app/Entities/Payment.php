<?php
declare(strict_types=1);

namespace Fiskalizacija\Entities;

use Fiskalizacija\Exceptions\PaymentTypeNotFoundException;

abstract class Payment
{

    /**
     * @return float
     */
    abstract public function amount(): float;

    /**
     * @return string
     * @throws PaymentTypeNotFoundException
     */
    public function name(): string
    {
        return match ($this->type()) {
            PaymentType::CASH->value => 'Готовина',
            PaymentType::CARD->value => 'Платна картица',
            PaymentType::CHECK->value => 'Чек',
            PaymentType::WIRE_TRANSFER->value => 'Вирман',
            PaymentType::VOUCHER->value => 'Ваучер',
            PaymentType::MOBILE_MONEY->value => 'Мобилни новац',
            default => throw new PaymentTypeNotFoundException(),
        };
    }

    /**
     * @return int
     */
    abstract public function type(): int;
}
