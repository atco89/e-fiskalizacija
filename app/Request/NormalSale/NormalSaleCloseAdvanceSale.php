<?php
declare(strict_types=1);

namespace TaxCore\Request\NormalSale;

use DateTimeInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\ReferentDocumentInterface;
use TaxCore\Request\NormalSale\AdvertisementItem\NormalSaleAdvertisementItem;
use TaxCore\Request\Sale;

final class NormalSaleCloseAdvanceSale extends Sale implements ReferentDocumentInterface
{

    /**
     * @var ReferentDocumentInterface
     */
    private ReferentDocumentInterface $referentDocument;

    /**
     * @param string $cashier
     * @param array $items
     * @param array $payment
     * @param ReferentDocumentInterface $buyer
     */
    public function __construct(
        string                    $cashier,
        array                     $items,
        array                     $payment,
        ReferentDocumentInterface $buyer
    )
    {
        parent::__construct($cashier, $items, $payment);
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
