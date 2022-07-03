<?php
declare(strict_types=1);

namespace TaxCore\Request;

use DateTimeInterface;
use Exception;
use TaxCore\Entities\AdvanceSaleAmountInterface;
use TaxCore\Entities\AdvertisementItemInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;
use TaxCore\Entities\ReferentDocumentInterface;
use TaxCore\Entities\TaxItemInterface;

abstract class CloseAdvanceSaleBuilder extends SaleBuilder
    implements ReferentDocumentInterface, AdvanceSaleAmountInterface
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
     * @var float
     */
    protected float $receivedAmount;

    /**
     * @var TaxItemInterface[]
     */
    protected array $receivedTax;

    /**
     * @var string
     */
    protected string $lastReferentDocumentNumber;

    /**
     * @var DateTimeInterface
     */
    protected DateTimeInterface $lastReferentDocumentDateTime;

    /**
     * @param ItemInterface[] $items
     * @param PaymentTypeInterface[] $payment
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param float $receivedAmount
     * @param TaxItemInterface[] $receivedTax
     * @param string $lastReferentDocumentNumber
     * @param DateTimeInterface $lastReferentDocumentDateTime
     */
    public function __construct(
        array             $items,
        array             $payment,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        float             $receivedAmount,
        array             $receivedTax,
        string            $lastReferentDocumentNumber,
        DateTimeInterface $lastReferentDocumentDateTime
    )
    {
        $this->referentDocumentNumber = $referentDocumentNumber;
        $this->referentDocumentDateTime = $referentDocumentDateTime;
        $this->receivedAmount = $receivedAmount;
        $this->receivedTax = $receivedTax;
        $this->lastReferentDocumentNumber = $lastReferentDocumentNumber;
        $this->lastReferentDocumentDateTime = $lastReferentDocumentDateTime;
        parent::__construct($items, $payment);
    }

    /**
     * @return InvoiceType
     */
    final public function invoiceType(): InvoiceType
    {
        return InvoiceType::NORMAL;
    }

    /**
     * @return float
     */
    final public function receivedTax(): float
    {
        return array_reduce($this->receivedTax, function (float|null $carry, TaxItemInterface $item): float {
            $carry += $item->amount();
            return $carry;
        });
    }

    /**
     * @return float
     * @noinspection PhpPureAttributeCanBeAddedInspection
     */
    final public function remainingAmount(): float
    {
        return round($this->amount() - $this->receivedAmount, 5);
    }

    /**
     * @return float
     * @noinspection PhpPureAttributeCanBeAddedInspection
     */
    final public function receivedAmount(): float
    {
        return $this->receivedAmount;
    }

    /**
     * @return array|null
     * @throws Exception
     */
    public function advertisementItems(): array|null
    {
        return [new class($this->lastReferentDocumentNumber, $this->lastReferentDocumentDateTime)
            implements AdvertisementItemInterface {

            /**
             * @var string
             */
            protected string $lastReferentDocumentNumber;

            /**
             * @var DateTimeInterface
             */
            protected DateTimeInterface $lastReferentDocumentDateTime;

            /**
             * @param string $lastReferentDocumentNumber
             * @param DateTimeInterface $lastReferentDocumentDateTime
             */
            public function __construct(
                string            $lastReferentDocumentNumber,
                DateTimeInterface $lastReferentDocumentDateTime
            )
            {
                $this->lastReferentDocumentNumber = $lastReferentDocumentNumber;
                $this->lastReferentDocumentDateTime = $lastReferentDocumentDateTime;
            }

            /**
             * @return string
             */
            public function name(): string
            {
                return implode(' ', [
                    $this->lastReferentDocumentNumber,
                    $this->lastReferentDocumentDateTime->format('d.m.Y')
                ]);
            }

            /**
             * @return float|null
             */
            public function amount(): float|null
            {
                return null;
            }
        }];
    }

    /**
     * @return string
     * @noinspection PhpPureAttributeCanBeAddedInspection
     */
    final public function referentDocumentNumber(): string
    {
        return $this->referentDocumentNumber;
    }

    /**
     * @return DateTimeInterface
     * @throws Exception
     */
    final public function referentDocumentDateTime(): DateTimeInterface
    {
        return $this->referentDocumentDateTime;
    }
}
