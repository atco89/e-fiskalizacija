<?php
declare(strict_types=1);

namespace TaxCore\Request\CopySale;

use DateTimeInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\ReferentDocumentInterface;
use TaxCore\Entities\Request\RequestWithReferentDocumentInterface;
use TaxCore\Request\SaleBuilder;

final class RequestCopySale extends SaleBuilder implements ReferentDocumentInterface
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
     * @param RequestWithReferentDocumentInterface $request
     */
    public function __construct(RequestWithReferentDocumentInterface $request)
    {
        $this->referentDocumentNumber = $request->referentDocumentNumber();
        $this->referentDocumentDateTime = $request->referentDocumentDateTime();
        parent::__construct($request);
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
