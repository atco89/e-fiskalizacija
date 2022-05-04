<?php
declare(strict_types=1);

namespace TaxCore\Entities;

use DateTimeInterface;

interface ReferentDocumentInterface
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