<?php
declare(strict_types=1);

namespace TaxCore\Request\NormalSale;

use TaxCore\Entities\BuyerCostCenterInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;
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
     * @param PaymentTypeInterface[] $payment
     * @param string $buyerId
     * @param string|null $buyerCostCenterId
     */
    public function __construct(array $items, array $payment, string $buyerId, string|null $buyerCostCenterId)
    {
        $this->buyerCostCenterId = $buyerCostCenterId;
        parent::__construct($items, $payment, $buyerId);
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
