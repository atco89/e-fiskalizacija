<?php
declare(strict_types=1);

namespace TaxCore\Request\NormalSale\ReferentDocument;

use DateTimeInterface;
use Exception;
use TaxCore\Entities\ReferentDocumentInterface;
use TaxCore\Response\Response;

final class ReferentDocument implements ReferentDocumentInterface
{

    /**
     * @var Response
     */
    private Response $response;

    /**
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return string
     * @noinspection PhpPureAttributeCanBeAddedInspection
     */
    public function referentDocumentNumber(): string
    {
        return $this->response->invoiceNumber();
    }

    /**
     * @return DateTimeInterface
     * @throws Exception
     */
    public function referentDocumentDateTime(): DateTimeInterface
    {
        return $this->response->sdcDateTime();
    }
}
