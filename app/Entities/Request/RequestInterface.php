<?php
declare(strict_types=1);

namespace TaxCore\Entities\Request;

use TaxCore\Entities\AdvanceSaleItem;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;

interface RequestInterface
{

    /**
     * @return ItemInterface[]
     */
    public function items(): array;

    /**
     * @return PaymentTypeInterface[]
     */
    public function payment(): array;

    /**
     * @return AdvanceSaleItem[]|null
     */
    public function advanceSaleItems(): array|null;
}
