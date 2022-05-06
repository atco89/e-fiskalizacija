<?php
declare(strict_types=1);

namespace TaxCore\Request;

use DateTimeInterface;
use Exception;
use TaxCore\Entities\AdvanceSaleAmountInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\Properties\RequestPropertiesInterface;
use TaxCore\Entities\ReferentDocumentInterface;
use TaxCore\Entities\TaxItemInterface;
use TaxCore\Response\Response;

abstract class CloseAdvanceSale extends Sale implements ReferentDocumentInterface, AdvanceSaleAmountInterface
{

    /**
     * @var Response
     */
    protected Response $response;

    /**
     * @param RequestPropertiesInterface $properties
     * @param Response $response
     */
    public function __construct(RequestPropertiesInterface $properties, Response $response)
    {
        parent::__construct($properties);
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
