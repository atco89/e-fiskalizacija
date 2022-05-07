<?php
declare(strict_types=1);

namespace TaxCore\Examples\Request;

use TaxCore\Entities\AdvanceSaleItemInterface;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;
use TaxCore\Entities\Request\RequestBuyerIdentifiedInterface;

final class AdvanceSaleBuyerIdentified implements RequestBuyerIdentifiedInterface
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
        return include __DIR__ . '/../data/advance-payment.php';
    }

    /**
     * @return string
     */
    public function buyerId(): string
    {
        return include __DIR__ . '/../data/buyer-id.php';
    }

    /**
     * @return AdvanceSaleItemInterface[]|null
     */
    public function advanceSaleItems(): array|null
    {
        return include __DIR__ . '/../data/advance-sale-items.php';
    }
}
