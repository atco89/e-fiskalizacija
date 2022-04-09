<?php
declare(strict_types=1);

namespace Fiskalizacija\Entities;

interface Buyer
{

    /**
     * Taxpayer ID of the Buyer. It is mandatory for B2B transactions; otherwise, it's optional.
     *
     * @return string|null
     */
    public function buyerId(): ?string;

    /**
     * Cost Center ID provided by the buyer to the cashier in case Buyer’s company wants to track spending in
     * Taxpayer Portal. It is optional and may exist only for B2B transactions; otherwise, it shall be ignored by E-SDC.
     *
     * @return string|null
     */
    public function buyerCostCenterId(): ?string;
}