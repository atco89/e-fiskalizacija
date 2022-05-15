<?php
declare(strict_types=1);

namespace TaxCore\Request;

use DateTimeInterface;
use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;

abstract class RefundBuyerIdentifiedBuilder extends RefundBuilder implements BuyerInterface
{

    /**
     * @var string
     */
    protected string $buyerId;

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param string $buyerId
     */
    public function __construct(
        array             $items,
        array             $payment,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        string            $buyerId
    )
    {
        $this->referentDocumentNumber = $referentDocumentNumber;
        $this->referentDocumentDateTime = $referentDocumentDateTime;
        $this->buyerId = $buyerId;
        parent::__construct($items, $payment, $referentDocumentNumber, $referentDocumentDateTime);
    }

    /**
     * @return string
     */
    public function buyerId(): string
    {
        return $this->buyerId;
    }
}
