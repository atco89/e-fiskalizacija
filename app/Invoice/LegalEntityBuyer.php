<?php
declare(strict_types=1);

namespace Fiskalizacija\Invoice;

use Fiskalizacija\Sale\Request;

final class LegalEntityBuyer
{

    /**
     * @var string|null
     */
    private ?string $tin;

    /**
     * @var string|null
     */
    private ?string $buyerCostCenter;

    /**
     * @param Request $request
     * @noinspection PhpPureAttributeCanBeAddedInspection
     */
    public function __construct(Request $request)
    {
        $this->tin = $request->getBuyerId();
        $this->buyerCostCenter = $request->getBuyerCostCenterId();
    }

    /**
     * @return string|null
     */
    public function getTin(): ?string
    {
        return $this->tin;
    }

    /**
     * @return string|null
     */
    public function getBuyerCostCenter(): ?string
    {
        return $this->buyerCostCenter;
    }
}
