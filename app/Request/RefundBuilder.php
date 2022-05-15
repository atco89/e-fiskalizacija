<?php
declare(strict_types=1);

namespace TaxCore\Request;

use DateTimeInterface;
use TaxCore\Entities\Enums\TransactionType;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;
use TaxCore\Entities\ReferentDocumentInterface;

abstract class RefundBuilder extends ApiRequestBase implements ReferentDocumentInterface
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
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     */
    public function __construct(
        array             $items,
        array             $payment,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime
    )
    {
        $this->referentDocumentNumber = $referentDocumentNumber;
        $this->referentDocumentDateTime = $referentDocumentDateTime;
        parent::__construct($items, $payment);
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
     * @return TransactionType
     */
    public function transactionType(): TransactionType
    {
        return TransactionType::REFUND;
    }
}
