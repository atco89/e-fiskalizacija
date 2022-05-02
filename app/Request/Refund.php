<?php
declare(strict_types=1);

namespace TaxCore\Request;

use DateTimeInterface;
use TaxCore\Entities\Enums\TransactionType;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;
use TaxCore\Entities\ReferentDocumentInterface;

abstract class Refund extends RequestInterfaceImpl implements ReferentDocumentInterface
{

    /**
     * @var ReferentDocumentInterface
     */
    protected ReferentDocumentInterface $document;

    /**
     * @param string $cashier
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param ReferentDocumentInterface $document
     */
    public function __construct(string $cashier, array $items, array $payment, ReferentDocumentInterface $document)
    {
        parent::__construct($cashier, $items, $payment);
        $this->document = $document;
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
        return $this->document->referentDocumentNumber();
    }

    /**
     * @return DateTimeInterface
     */
    final public function referentDocumentDateTime(): DateTimeInterface
    {
        return $this->document->referentDocumentDateTime();
    }
}
