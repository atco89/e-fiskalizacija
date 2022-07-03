<?php
declare(strict_types=1);

namespace TaxCore\Request\NormalSale;

use DateTimeInterface;
use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;
use TaxCore\Entities\TaxItemInterface;
use TaxCore\Request\CloseAdvanceSaleBuilder;

final class RequestNormalSaleBuyerIdentifiedWithClosingAdvanceSale extends CloseAdvanceSaleBuilder
    implements BuyerInterface
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
     * @param float $receivedAmount
     * @param TaxItemInterface[] $receivedTax
     * @param string $lastReferentDocumentNumber
     * @param DateTimeInterface $lastReferentDocumentDateTime
     * @param string $buyerId
     */
    public function __construct(
        array             $items,
        array             $payment,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        float             $receivedAmount,
        array             $receivedTax,
        string            $lastReferentDocumentNumber,
        DateTimeInterface $lastReferentDocumentDateTime,
        string            $buyerId
    )
    {
        $this->buyerId = $buyerId;
        parent::__construct(
            $items,
            $payment,
            $referentDocumentNumber,
            $referentDocumentDateTime,
            $receivedAmount,
            $receivedTax,
            $lastReferentDocumentNumber,
            $lastReferentDocumentDateTime
        );
    }

    /**
     * @return string
     */
    public function buyerId(): string
    {
        return $this->buyerId;
    }
}
