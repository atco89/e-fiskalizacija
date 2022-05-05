<?php
declare(strict_types=1);

namespace TaxCore\Request;

use DateTimeInterface;
use TaxCore\Entities\Enums\TransactionType;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;
use TaxCore\Entities\ReferentDocumentInterface;

abstract class Refund extends RequestBase implements ReferentDocumentInterface
{

    /**
     * @var ReferentDocumentInterface
     */
    protected ReferentDocumentInterface $referentDocument;

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
     * @return TransactionType
     */
    final public function transactionType(): TransactionType
    {
        return TransactionType::REFUND;
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
}
