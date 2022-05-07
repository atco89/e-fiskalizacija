<?php
declare(strict_types=1);

namespace TaxCore\Request;

use DateTimeInterface;
use Exception;
use TaxCore\Entities\AdvanceSaleAmountInterface;
use TaxCore\Entities\AdvertisementItemInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\ReferentDocumentInterface;
use TaxCore\Entities\Request\RequestWithReferentDocumentInterface;
use TaxCore\Entities\TaxItemInterface;
use TaxCore\Response\Response;

abstract class CloseAdvanceSaleBuilder extends SaleBuilder
    implements ReferentDocumentInterface, AdvanceSaleAmountInterface
{

    /**
     * @var Response
     */
    protected Response $response;

    /**
     * @param RequestWithReferentDocumentInterface $request
     * @param Response $response
     */
    public function __construct(RequestWithReferentDocumentInterface $request, Response $response)
    {
        parent::__construct($request);
        $this->response = $response;
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
        return array_reduce($this->response->taxItems(), function (float|null $carry, TaxItemInterface $item): float {
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
        return round($this->amount() - $this->receivedAmount(), 5);
    }

    /**
     * @return float
     * @noinspection PhpPureAttributeCanBeAddedInspection
     */
    final public function receivedAmount(): float
    {
        return $this->response->totalAmount();
    }

    /**
     * @return array|null
     * @throws Exception
     */
    public function advertisementItems(): array|null
    {
        return [new class($this->referentDocumentNumber(), $this->referentDocumentDateTime())
            implements AdvertisementItemInterface {

            /**
             * @var string
             */
            protected string $referentDocumentNumber;

            /**
             * @var DateTimeInterface
             */
            protected DateTimeInterface $referentDocumentDateTime;

            /**
             * @param string $referentDocumentNumber
             * @param DateTimeInterface $referentDocumentDateTime
             */
            public function __construct(string $referentDocumentNumber, DateTimeInterface $referentDocumentDateTime)
            {
                $this->referentDocumentNumber = $referentDocumentNumber;
                $this->referentDocumentDateTime = $referentDocumentDateTime;
            }

            /**
             * @return string
             */
            public function name(): string
            {
                return implode(' ', [
                    $this->referentDocumentNumber,
                    $this->referentDocumentDateTime->format('d.m.Y')
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
        return $this->response->invoiceNumber();
    }

    /**
     * @return DateTimeInterface
     * @throws Exception
     */
    final public function referentDocumentDateTime(): DateTimeInterface
    {
        return $this->response->sdcDateTime();
    }
}
