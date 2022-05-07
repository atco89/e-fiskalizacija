<?php
declare(strict_types=1);

namespace TaxCore\Entities\Request;

interface RequestBuyerIdentifiedInterface extends RequestInterface
{

    /**
     * @return string
     */
    public function buyerId(): string;
}