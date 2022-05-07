<?php
declare(strict_types=1);

namespace TaxCore\Request\NormalSale;

use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\Request\RequestBuyerIdentifiedInterface;
use TaxCore\Request\CloseAdvanceSaleBuilder;
use TaxCore\Response\Response;

final class RequestNormalSaleBuyerIdentifiedWithClosingAdvanceSale extends CloseAdvanceSaleBuilder
    implements BuyerInterface
{

    /**
     * @var string
     */
    protected string $buyerId;

    /**
     * @param RequestBuyerIdentifiedInterface $request
     * @param Response $response
     */
    public function __construct(
        RequestBuyerIdentifiedInterface $request,
        Response                        $response
    )
    {
        $this->buyerId = $request->buyerId();
        parent::__construct($request, $response);
    }

    /**
     * @return string
     */
    public function buyerId(): string
    {
        return $this->buyerId;
    }
}
