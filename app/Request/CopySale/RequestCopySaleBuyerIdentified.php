<?php
declare(strict_types=1);

namespace TaxCore\Request\CopySale;

use DateTimeInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\ReferentDocumentInterface;
use TaxCore\Entities\Request\RequestWithReferentDocumentBuyerIdentifiedInterface;
use TaxCore\Request\SaleBuyerIdentifiedBuilder;

final class RequestCopySaleBuyerIdentified extends SaleBuyerIdentifiedBuilder implements ReferentDocumentInterface
{

    /**
     * @var string
     */
    protected string $referentDocumentNumber;

    /**
     * @var DateTimeInterface
     */
    protected DateTimeInterface $referentDocumentDateTime;

    /**
     * @param RequestWithReferentDocumentBuyerIdentifiedInterface $request
     */
    public function __construct(RequestWithReferentDocumentBuyerIdentifiedInterface $request)
    {
        parent::__construct($request);
        $this->referentDocumentNumber = $request->referentDocumentNumber();
        $this->referentDocumentDateTime = $request->referentDocumentDateTime();
    }

    /**
     * @return string
     */
    public function referentDocumentNumber(): string
    {
        return $this->referentDocumentNumber;
    }

    /**
     * @return DateTimeInterface
     */
    public function referentDocumentDateTime(): DateTimeInterface
    {
        return $this->referentDocumentDateTime;
    }

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::COPY;
    }
}
