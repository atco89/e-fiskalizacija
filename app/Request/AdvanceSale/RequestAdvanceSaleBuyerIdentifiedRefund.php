<?php
declare(strict_types=1);

namespace TaxCore\Request\AdvanceSale;

use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\Request\RequestBuyerIdentifiedInterface;
use TaxCore\Request\AdvanceSaleRefundBuilder;

final class RequestAdvanceSaleBuyerIdentifiedRefund extends AdvanceSaleRefundBuilder implements BuyerInterface
{

    /**
     * @var string
     */
    protected string $buyerId;

    /**
     * @param RequestBuyerIdentifiedInterface $request
     */
    public function __construct(RequestBuyerIdentifiedInterface $request)
    {
        $this->buyerId = $request->buyerId();
        parent::__construct($request);
    }

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::ADVANCE;
    }

    /**
     * @return string
     */
    public function buyerId(): string
    {
        return $this->buyerId;
    }
}
