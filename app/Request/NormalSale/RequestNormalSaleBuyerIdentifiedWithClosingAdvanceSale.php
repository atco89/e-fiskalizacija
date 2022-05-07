<?php
declare(strict_types=1);

namespace TaxCore\Request\NormalSale;

use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\Request\RequestWithReferentDocumentBuyerIdentifiedInterface;
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
     * @param RequestWithReferentDocumentBuyerIdentifiedInterface $request
     * @param Response $response
     */
    public function __construct(
        RequestWithReferentDocumentBuyerIdentifiedInterface $request,
        Response                                            $response
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
