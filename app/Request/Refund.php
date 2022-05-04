<?php
declare(strict_types=1);

namespace TaxCore\Request;

use DateTimeInterface;
use TaxCore\Entities\Enums\TransactionType;
use TaxCore\Entities\ReferentDocumentInterface;

abstract class Refund extends RequestBase implements ReferentDocumentInterface
{

    /**
     * @var ReferentDocumentInterface
     */
    protected ReferentDocumentInterface $referentDocument;

    /**
     * @param string $cashier
     * @param string $invoiceNumber
     * @param array $items
     * @param array $payment
     * @param ReferentDocumentInterface $referentDocument
     */
    public function __construct(
        string                    $cashier,
        string                    $invoiceNumber,
        array                     $items,
        array                     $payment,
        ReferentDocumentInterface $referentDocument
    )
    {
        parent::__construct($cashier, $invoiceNumber, $items, $payment);
        $this->referentDocument = $referentDocument;
    }

    /**
     * @return string
     */
    final public function referentDocumentNumber(): string
    {
        return $this->referentDocument->referentDocumentNumber();
    }

    /**
     * @return DateTimeInterface
     */
    final public function referentDocumentDateTime(): DateTimeInterface
    {
        return $this->referentDocument->referentDocumentDateTime();
    }

    /**
     * @return TransactionType
     */
    final public function transactionType(): TransactionType
    {
        return TransactionType::REFUND;
    }
}
