<?php
declare(strict_types=1);

namespace TaxCore\Entities\Request;

use DateTimeInterface;

interface RequestWithReferentDocumentInterface extends RequestInterface
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
