<?php
declare(strict_types=1);

namespace TaxCore\Request;

use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\Request\RequestWithReferentDocumentBuyerIdentifiedInterface;

abstract class RefundBuyerIdentifiedBuilder extends RefundBuilder implements BuyerInterface
{

    /**
     * @var string
     */
    protected string $buyerId;

    /**
     * @param RequestWithReferentDocumentBuyerIdentifiedInterface $request
     */
    public function __construct(RequestWithReferentDocumentBuyerIdentifiedInterface $request)
    {
        $this->buyerId = $request->buyerId();
        parent::__construct($request);
    }

    /**
     * @return string
     */
    public function buyerId(): string
    {
        return $this->buyerId;
    }
}
