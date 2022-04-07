<?php
declare(strict_types=1);

namespace Fiskalizacija\Entities;

use Fiskalizacija\Enums\PaymentType;
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
    final public function name(): string
    {
        switch ($this->type()) {
            case PaymentType::CASH:
                return 'Готовина';
            case PaymentType::CARD:
                return 'Платна картица';
            case PaymentType::CHECK:
                return 'Чекови';
            case PaymentType::WIRE_TRANSFER:
                return 'Вирман';
            case PaymentType::VOUCHER:
                return 'Ваучер';
            case PaymentType::MOBILE_MONEY:
                return 'Мобилно плаћање';
        }
        throw new PaymentTypeNotFoundException();
    }

    /**
     * @return int
     */
    abstract public function type(): int;
}
