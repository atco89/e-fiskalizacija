<?php
declare(strict_types=1);

namespace TaxCore\Examples\Request;

use TaxCore\Entities\AdvanceSaleItemInterface;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\Request\RequestInterface;

final class AdvanceSale implements RequestInterface
{

    /**
     * @return ItemInterface[]
     */
    public function items(): array
    {
        return include __DIR__ . '/../data/items.php';
    }

    /**
     * @return AdvanceSaleItemInterface[]|null
     */
    public function advanceSaleItems(): array|null
    {
        return include __DIR__ . '/../data/advance-sale-items.php';
    }
}
