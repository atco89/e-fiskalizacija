<?php
declare(strict_types=1);

namespace TaxCore\Entities;

use DateTime;

interface Document
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