<?php
declare(strict_types=1);

namespace TaxCore\Request\Copy;

use DateTimeInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;
use TaxCore\Entities\ReferentDocumentInterface;
use TaxCore\Request\Sale;

final class CopySale extends Sale implements ReferentDocumentInterface
{

    /**
     * @var ReferentDocumentInterface
     */
    private ReferentDocumentInterface $referentDocument;

    /**
     * @param string $cashier
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param ReferentDocumentInterface $referentDocument
     */
    public function __construct(
        string                    $cashier,
        array                     $items,
        array                     $payment,
        ReferentDocumentInterface $referentDocument
    )
    {
        parent::__construct($cashier, $items, $payment);
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
