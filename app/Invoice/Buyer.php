<?php
declare(strict_types=1);

namespace Fiskalizacija\Invoice;

use DateTime;
use Fiskalizacija\Sale\Request;

final class Buyer
{

    /**
     * @var string
     */
    private string $cashier;

    /**
     * @var string|null
     */
    private ?string $taxIdentificationNumber;

    /**
     * @var string|null
     */
    private ?string $buyerCostCenter;

    /**
     * @var string
     */
    private string $invoiceNumber;

    /**
     * @var DateTime
     */
    private DateTime $dateAndTimeOfIssue;

    /**
     * @var string|null
     */
    private ?string $referentDocumentNumber;

    /**
     * @var string|null
     */
    private ?string $referentDocumentDateAndTime;

    /**
     * @param Request $request
     * @noinspection PhpPureAttributeCanBeAddedInspection
     */
    public function __construct(Request $request)
    {
        $this->cashier = $request->getCashierId();
        $this->taxIdentificationNumber = $request->getBuyerId();
        $this->buyerCostCenter = $request->getBuyerCostCenterId();
        $this->invoiceNumber = $request->getInvoiceNumber();
        $this->dateAndTimeOfIssue = $request->getDateAndTimeOfIssue();
        $this->referentDocumentNumber = $request->getReferentDocumentNumber();
        $this->referentDocumentDateAndTime = $request->getReferentDocumentDT();
    }

    /**
     * @return string
     */
    public function getCashier(): string
    {
        return $this->cashier;
    }

    /**
     * @return string|null
     */
    public function getTaxIdentificationNumber(): ?string
    {
        return $this->taxIdentificationNumber;
    }

    /**
     * @return string|null
     */
    public function getBuyerCostCenter(): ?string
    {
        return $this->buyerCostCenter;
    }

    /**
     * @return string
     */
    public function getInvoiceNumber(): string
    {
        return $this->invoiceNumber;
    }

    /**
     * @return DateTime
     */
    public function getDateAndTimeOfIssue(): DateTime
    {
        return $this->dateAndTimeOfIssue;
    }

    /**
     * @return string|null
     */
    public function getReferentDocumentNumber(): ?string
    {
        return $this->referentDocumentNumber;
    }

    /**
     * @return string|null
     */
    public function getReferentDocumentDateAndTime(): ?string
    {
        return $this->referentDocumentDateAndTime;
    }
}
