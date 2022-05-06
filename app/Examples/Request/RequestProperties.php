<?php
declare(strict_types=1);

namespace TaxCore\Examples\Request;

use TaxCore\Entities\Properties\RequestPropertiesInterface;

final class RequestProperties implements RequestPropertiesInterface
{

    /**
     * @return array
     */
    public function items(): array
    {
        return include __DIR__ . '/../data/items.php';
    }

    /**
     * @return array
     */
    public function payment(): array
    {
        return include __DIR__ . '/../data/payment.php';
    }
}
