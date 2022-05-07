<?php
declare(strict_types=1);

namespace TaxCore\Request\NormalSale;

use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\Request\RequestWithReferentDocumentInterface;
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
     * @param RequestWithReferentDocumentInterface $request
     * @param Response $response
     */
    public function __construct(
        RequestWithReferentDocumentInterface $request,
        Response                             $response
    )
    {
        parent::__construct($request, $response);
        $this->buyerId = $request->buyerId();
    }

    /**
     * @return string
     */
    public function buyerId(): string
    {
        return $this->buyerId;
    }
}
