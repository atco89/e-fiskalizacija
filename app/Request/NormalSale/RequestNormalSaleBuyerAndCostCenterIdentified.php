<?php
declare(strict_types=1);

namespace TaxCore\Request\NormalSale;

use TaxCore\Entities\BuyerCostCenterInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\ItemInterface;
use TaxCore\Request\SaleBuyerIdentifiedBuilder;

final class RequestNormalSaleBuyerAndCostCenterIdentified extends SaleBuyerIdentifiedBuilder
    implements BuyerCostCenterInterface
{

    /**
     * @var string|null
     */
    protected string|null $buyerCostCenterId;

    /**
     * @param ItemInterface[] $items
     * @param string $buyerId
     * @param string|null $buyerCostCenterId
     */
    public function __construct(array $items, string $buyerId, string|null $buyerCostCenterId)
    {
        parent::__construct($items, $buyerId);
        $this->buyerCostCenterId = $buyerCostCenterId;
    }

    /**
     * @return string|null
     */
    public function buyerCostCenterId(): string|null
    {
        return $this->buyerCostCenterId;
    }

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::NORMAL;
    }
}
