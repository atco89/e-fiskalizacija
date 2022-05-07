<?php
declare(strict_types=1);

namespace TaxCore\Examples\Request;

use TaxCore\Entities\AdvanceSaleItem;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;
use TaxCore\Entities\Request\RequestInterface;

final class NormalSale implements RequestInterface
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

    /**
     * @return AdvanceSaleItem[]|null
     */
    public function advanceSaleItems(): array|null
    {
        return null;
    }
}
