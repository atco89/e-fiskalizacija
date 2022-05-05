<?php
declare(strict_types=1);

namespace TaxCore\Request\NormalSale\AdvertisementItem;

use TaxCore\Entities\AdvertisementItemInterface;
use TaxCore\Entities\ReferentDocumentInterface;

final class NormalSaleAdvertisementItem implements AdvertisementItemInterface
{

    /**
     * @var ReferentDocumentInterface
     */
    protected ReferentDocumentInterface $referentDocument;

    /**
     * @param ReferentDocumentInterface $referentDocument
     */
    public function __construct(ReferentDocumentInterface $referentDocument)
    {
        $this->referentDocument = $referentDocument;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return implode(' ', [
            $this->referentDocument->referentDocumentNumber(),
            $this->referentDocument->referentDocumentDateTime(),
        ]);
    }

    /**
     * @return float|null
     */
    public function amount(): float|null
    {
        return null;
    }
}
