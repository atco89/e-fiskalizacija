<?php
declare(strict_types=1);

namespace TaxCore\Request;

use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\Request\RequestBuyerIdentifiedInterface;

abstract class SaleBuyerIdentifiedBuilder extends SaleBuilder implements BuyerInterface
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
     * @return string
     */
    public function buyerId(): string
    {
        return $this->buyerId;
    }
}
