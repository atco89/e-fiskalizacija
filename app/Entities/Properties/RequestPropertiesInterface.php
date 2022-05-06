<?php
declare(strict_types=1);

namespace TaxCore\Entities\Properties;

use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;

interface RequestPropertiesInterface
{

    /**
     * @return ItemInterface[]
     */
    public function items(): array;

    /**
     * @return PaymentTypeInterface[]
     */
    public function payment(): array;
}
