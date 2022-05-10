<?php
declare(strict_types=1);

namespace TaxCore\Request\NormalSale;

use DateTimeInterface;
use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\ItemInterface;
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
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param float $receivedAmount
     * @param TaxItemInterface[] $receivedTax
     * @param string $buyerId
     */
    public function __construct(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        float             $receivedAmount,
        array             $receivedTax,
        string            $buyerId
    )
    {
        parent::__construct($items, $referentDocumentNumber, $referentDocumentDateTime, $receivedAmount, $receivedTax);
        $this->buyerId = $buyerId;
    }

    /**
     * @return string
     */
    public function buyerId(): string
    {
        return $this->buyerId;
    }
}
