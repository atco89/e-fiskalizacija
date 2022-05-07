<?php
declare(strict_types=1);

namespace TaxCore\Examples\Request;

use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;
use TaxCore\Entities\Request\RequestPropertiesInterface;

final class RequestSaleProperties implements RequestPropertiesInterface
{

    /**
     * @return ItemInterface[]
     */
    public function items(): array
    {
        return include __DIR__ . '/../data/items.php';
    }

    /**
     * @return PaymentTypeInterface[]
     */
    public function payment(): array
    {
        return include __DIR__ . '/../data/payment.php';
    }
}
