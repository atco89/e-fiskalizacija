<?php
declare(strict_types=1);

namespace TaxCore\Request\AdvanceSale;

use DateTimeInterface;
use TaxCore\Entities\AdvanceSaleItemInterface;
use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\ItemInterface;
use TaxCore\Request\AdvanceSaleRefundBuilder;

final class RequestAdvanceSaleBuyerIdentifiedRefund extends AdvanceSaleRefundBuilder implements BuyerInterface
{

    /**
     * @var string
     */
    protected string $buyerId;

    /**
     * @param ItemInterface[] $items
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     * @param AdvanceSaleItemInterface[] $advanceSaleItems
     * @param string $buyerId
     */
    public function __construct(
        array             $items,
        string            $referentDocumentNumber,
        DateTimeInterface $referentDocumentDateTime,
        array             $advanceSaleItems,
        string            $buyerId
    )
    {
        parent::__construct($items, $referentDocumentNumber, $referentDocumentDateTime, $advanceSaleItems);
        $this->buyerId = $buyerId;
    }

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::ADVANCE;
    }

    /**
     * @return string
     */
    public function buyerId(): string
    {
        return $this->buyerId;
    }
}
