<?php
declare(strict_types=1);

namespace TaxCore\Entities;

use DateTime;

interface ReferentDocumentInterface
{

    /**
     * @return string
     */
    public function referentDocumentNumber(): string;

    /**
     * @return DateTime
     */
    public function referentDocumentDateTime(): DateTime;
}