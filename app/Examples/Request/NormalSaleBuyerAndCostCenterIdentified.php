<?php
declare(strict_types=1);

namespace TaxCore\Examples\Request;

use TaxCore\Entities\AdvanceSaleItemInterface;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\Request\RequestBuyerAndCostCenterIdentifiedInterface;

final class NormalSaleBuyerAndCostCenterIdentified implements RequestBuyerAndCostCenterIdentifiedInterface
{

    /**
     * @return string|null
     */
    public function buyerCostCenterId(): string|null
    {
        return include __DIR__ . '/../data/buyer-cost-center-id.php';
    }

    /**
     * @return string
     */
    public function buyerId(): string
    {
        return include __DIR__ . '/../data/buyer-id.php';
    }

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
        return null;
    }
}
