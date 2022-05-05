<?php
declare(strict_types=1);

namespace TaxCore\Request\CopySale;

use DateTimeInterface;
use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;
use TaxCore\Entities\ReferentDocumentInterface;
use TaxCore\Request\SaleCustomerIdentified;

final class CopySaleCustomerIdentifiedRequest extends SaleCustomerIdentified implements ReferentDocumentInterface
{

    /**
     * @var ReferentDocumentInterface
     */
    private ReferentDocumentInterface $referentDocument;

    /**
     * @param string $cashier
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param BuyerInterface $buyer
     * @param ReferentDocumentInterface $referentDocument
     */
    public function __construct(
        string                    $cashier,
        array                     $items,
        array                     $payment,
        BuyerInterface            $buyer,
        ReferentDocumentInterface $referentDocument
    )
    {
        parent::__construct($cashier, $items, $payment, $buyer);
        $this->referentDocument = $referentDocument;
    }

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::COPY;
    }

    /**
     * @return string
     */
    public function referentDocumentNumber(): string
    {
        return $this->referentDocument->referentDocumentNumber();
    }

    /**
     * @return DateTimeInterface
     */
    public function referentDocumentDateTime(): DateTimeInterface
    {
        return $this->referentDocument->referentDocumentDateTime();
    }
}
