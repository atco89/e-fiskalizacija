<?php
declare(strict_types=1);

namespace TaxCore\Request\NormalSale;

use TaxCore\Entities\BuyerCostCenterInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\Request\RequestBuyerAndCostCenterIdentifiedInterface;
use TaxCore\Request\SaleBuyerIdentifiedBuilder;

final class RequestNormalSaleBuyerAndCostCenterIdentified extends SaleBuyerIdentifiedBuilder
    implements BuyerCostCenterInterface
{

    /**
     * @var string|null
     */
    protected string|null $buyerCostCenterId;

    /**
     * @param RequestBuyerAndCostCenterIdentifiedInterface $request
     */
    public function __construct(RequestBuyerAndCostCenterIdentifiedInterface $request)
    {
        $this->buyerCostCenterId = $request->buyerCostCenterId();
        parent::__construct($request);
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
