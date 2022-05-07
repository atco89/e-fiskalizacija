<?php
declare(strict_types=1);

namespace TaxCore\Request;

use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\Request\RequestBuyerIdentifiedInterface;

abstract class AdvanceSaleBuyerIdentifiedBuilder extends AdvanceSaleBuilder implements BuyerInterface
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
        parent::__construct($request);
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
