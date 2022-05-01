<?php
declare(strict_types=1);

namespace TaxCore\Request\Copy;

use DateTime;
use Exception;
use TaxCore\Entities\BuyerInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\ReferentDocumentInterface;
use TaxCore\Request\Sale;

final class CopySaleCustomer extends Sale implements BuyerInterface, ReferentDocumentInterface
{

    /**
     * @var array
     */
    private array $buyer;

    /**
     * @var array
     */
    private array $referentDocument;

    /**
     * @param string $cashier
     * @param array $items
     * @param array $payment
     * @param array $buyer
     * @param array $referentDocument
     */
    public function __construct(string $cashier, array $items, array $payment, array $buyer, array $referentDocument)
    {
        parent::__construct($cashier, $items, $payment);
        $this->buyer = $buyer;
        $this->referentDocument = $referentDocument;
    }

    /**
     * @return string
     */
    public function buyerId(): string
    {
        return $this->buyer['buyerId'];
    }

    /**
     * @return string|null
     */
    public function buyerCostCenterId(): string|null
    {
        return $this->buyer['buyerCostCenterId'];
    }

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::COPY;
    }

    /**
     * @return string
     */
    public function referentDocumentNumber(): string
    {
        return $this->referentDocument['referentDocumentNumber'];
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function referentDocumentDateTime(): DateTime
    {
        return new DateTime($this->referentDocument['referentDocumentDateTime']);
    }
}
