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
     * @param array $items
     * @param array $payment
     * @param ReferentDocumentInterface $buyer
     */
    public function __construct(
        string                    $cashier,
        array                     $items,
        array                     $payment,
        ReferentDocumentInterface $buyer
    )
    {
        parent::__construct($cashier, $items, $payment);
        $this->referentDocument = $buyer;
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
