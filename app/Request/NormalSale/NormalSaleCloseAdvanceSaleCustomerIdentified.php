<?php
declare(strict_types=1);

namespace TaxCore\Request\NormalSale;

use DateTimeInterface;
use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\ReferentDocumentInterface;
use TaxCore\Request\NormalSale\AdvertisementItem\NormalSaleAdvertisementItem;
use TaxCore\Request\SaleCustomerIdentified;

final class NormalSaleCloseAdvanceSaleCustomerIdentified extends SaleCustomerIdentified implements ReferentDocumentInterface
{

    /**
     * @var ReferentDocumentInterface
     */
    private ReferentDocumentInterface $referentDocument;

    /**
     * @param string $cashier
     * @param array $items
     * @param array $payment
     * @param BuyerInterface $buyer
     * @param ReferentDocumentInterface $buyer
     */
    public function __construct(
        string                    $cashier,
        array                     $items,
        array                     $payment,
        BuyerInterface            $buyer,
        ReferentDocumentInterface $referentDocument
    )
    {
        parent::__construct($cashier, $items, $payment, $buyer);
        $this->referentDocument = $buyer;
    }

    /**
     * @return string
     */
    public function referentDocumentNumber(): string
    {
        return $this->referentDocument->referentDocumentNumber();
    }

    /**
     * @return DateTimeInterface
     */
    public function referentDocumentDateTime(): DateTimeInterface
    {
        return $this->referentDocument->referentDocumentDateTime();
    }

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::NORMAL;
    }

    /**
     * @return array|null
     * @noinspection PhpPureAttributeCanBeAddedInspection
     */
    public function advertisementItems(): array|null
    {
        return [new NormalSaleAdvertisementItem($this->referentDocument)];
    }
}
