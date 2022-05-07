<?php
declare(strict_types=1);

namespace TaxCore\Entities\Request;

interface RequestWithReferentDocumentBuyerIdentifiedInterface extends RequestWithReferentDocumentInterface
{

    /**
     * @return string
     */
    public function buyerId(): string;
}