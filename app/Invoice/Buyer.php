<?php
declare(strict_types=1);

namespace Fiskalizacija\Invoice;

use Fiskalizacija\Sale\Request;

final class Buyer
{

    /**
     * @var string|null
     */
    private ?string $taxIdentificationNumber;

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
        $this->taxIdentificationNumber = $request->getBuyerId();
        $this->buyerCostCenter = $request->getBuyerCostCenterId();
    }

    /**
     * @return string|null
     */
    public function getTaxIdentificationNumber(): ?string
    {
        return $this->taxIdentificationNumber;
    }

    /**
     * @return string|null
     */
    public function getBuyerCostCenter(): ?string
    {
        return $this->buyerCostCenter;
    }
}
