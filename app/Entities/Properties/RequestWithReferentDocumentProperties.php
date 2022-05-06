<?php
declare(strict_types=1);

namespace TaxCore\Entities\Properties;

use DateTimeInterface;

interface RequestWithReferentDocumentProperties extends RequestPropertiesInterface
{

    /**
     * @return string
     */
    public function referentDocumentNumber(): string;

    /**
     * @return DateTimeInterface
     */
    public function referentDocumentDateTime(): DateTimeInterface;
}