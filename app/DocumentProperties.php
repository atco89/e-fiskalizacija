<?php
declare(strict_types=1);

namespace Fiskalizacija;

use DateTime;
use Exception;
use Fiskalizacija\Interfaces\Invoice;
use Fiskalizacija\Interfaces\TaxItem;

final class DocumentProperties
{

    /**
     * @var Invoice
     */
    private Invoice $invoice;

    /**
     * @var TaxItem[]
     */
    private array $taxItems;

    /**
     * @var float
     */
    private float $taxAmount;

    /**
     * @var DateTime
     */
    private DateTime $sdcDateTime;

    /**
     * @var string
     */
    private string $sdcInterfacesNumber;

    /**
     * @var string
     */
    private string $invoiceCounter;

    /**
     * @var string
     */
    private string $verificationQRCode;

    /**
     * @param Invoice $invoice
     * @param Response $response
     * @throws Exception
     */
    public function __construct(Invoice $invoice, Response $response)
    {
        $this->invoice = $invoice;
        $this->taxItems = $response->taxItems();
        $this->taxAmount = $this->loadTaxAmount($this->taxItems);
        $this->sdcDateTime = $response->sdcDateTime();
        $this->sdcInterfacesNumber = $response->invoiceNumber();
        $this->invoiceCounter = $response->invoiceCounter();
        $this->verificationQRCode = $response->verificationQRCode();
    }

    /**
     * @param TaxItem[] $taxItems
     * @return float
     */
    private function loadTaxAmount(array $taxItems): float
    {
        if (empty($taxItems)) {
            return 0.0000;
        }

        return array_reduce($taxItems, function (?float $carry, TaxItem $item): float {
            $carry += $item->amount();
            return $carry;
        });
    }

    /**
     * @return Invoice
     */
    public function getInvoice(): Invoice
    {
        return $this->invoice;
    }

    /**
     * @return TaxItem[]
     */
    public function getTaxItems(): array
    {
        return $this->taxItems;
    }

    /**
     * @return float
     */
    public function getTaxAmount(): float
    {
        return $this->taxAmount;
    }

    /**
     * @return DateTime
     */
    public function getSdcDateTime(): DateTime
    {
        return $this->sdcDateTime;
    }

    /**
     * @return string
     */
    public function getSdcInterfacesNumber(): string
    {
        return $this->sdcInterfacesNumber;
    }

    /**
     * @return string
     */
    public function getInvoiceCounter(): string
    {
        return $this->invoiceCounter;
    }

    /**
     * @return string
     */
    public function getVerificationQRCode(): string
    {
        return $this->verificationQRCode;
    }
}