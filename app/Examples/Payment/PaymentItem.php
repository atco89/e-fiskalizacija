<?php
declare(strict_types=1);

namespace TaxCore\Examples\Payment;

use Exception;
use TaxCore\Entities\Enums\PaymentType;
use TaxCore\Entities\PaymentTypeInterface;

final class PaymentItem implements PaymentTypeInterface
{

    private array $item;

    /**
     * @param array $item
     */
    public function __construct(array $item)
    {
        $this->item = $item;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function name(): string
    {
        return match ($this->type()) {
            PaymentType::CASH          => 'Готовина',
            PaymentType::CARD          => 'Платна картица',
            PaymentType::CHECK         => 'Чек',
            PaymentType::WIRE_TRANSFER => 'Друго безготовинско плаћање',
            default                    => throw new Exception('Unexpected match value'),
        };
    }

    /**
     * @return PaymentType
     */
    public function type(): PaymentType
    {
        return PaymentType::from(intval($this->item['type']));
    }

    /**
     * @return float
     */
    public function amount(): float
    {
        return floatval($this->item['amount']);
    }
}
