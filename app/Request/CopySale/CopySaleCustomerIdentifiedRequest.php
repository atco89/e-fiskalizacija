<?php
declare(strict_types=1);

namespace TaxCore\Request\CopySale;

use DateTimeInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\Properties\RequestWithReferentDocumentProperties;
use TaxCore\Entities\ReferentDocumentInterface;
use TaxCore\Request\SaleCustomerIdentified;

final class CopySaleCustomerIdentifiedRequest extends SaleCustomerIdentified implements ReferentDocumentInterface
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
     * @param RequestWithReferentDocumentProperties $properties
     */
    public function __construct(RequestWithReferentDocumentProperties $properties)
    {
        parent::__construct($properties);
        $this->referentDocumentNumber = $properties->referentDocumentNumber();
        $this->referentDocumentDateTime = $properties->referentDocumentDateTime();
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
