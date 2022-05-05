<?php
declare(strict_types=1);

use TaxCore\Entities\ReferentDocumentInterface;

return new class implements ReferentDocumentInterface {

    /**
     * @return string
     */
    public function referentDocumentNumber(): string
    {
        return '5M2A3C4M-5M2A3C4M-849';
    }

    /**
     * @return DateTimeInterface
     */
    public function referentDocumentDateTime(): DateTimeInterface
    {
        return new DateTime('04.05.2022 13:03:11');
    }
};
