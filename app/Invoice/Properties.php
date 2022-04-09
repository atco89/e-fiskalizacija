<?php
declare(strict_types=1);

namespace Fiskalizacija\Invoice;

use DateTime;
use Exception;
use Fiskalizacija\Entities\Cashier;
use Fiskalizacija\Entities\Configuration;
use Fiskalizacija\Entities\Item;
use Fiskalizacija\Entities\Payment;
use Fiskalizacija\Entities\TaxItem;
use Fiskalizacija\Sale\Request;
use Fiskalizacija\Sale\Response;

final class Properties
{

    /**
     * @var Configuration
     */
    private Configuration $configuration;

    /**
     * @var Buyer
     */
    private Buyer $buyer;

    /**
     * @var Cashier
     */
    private Cashier $cashier;

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
     * @var float
     */
    private float $amount;

    /**
     * @var Item[]
     */
    private array $items;

    /**
     * @var Payment[]
     */
    private array $payment;

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
    private string $qrCode;

    /**
     * @param Configuration $configuration
     * @param Request $request
     * @param Response $response
     * @throws Exception
     */
    public function __construct(Configuration $configuration, Request $request, Response $response)
    {
        $this->configuration = $configuration;
        $this->buyer = new Buyer($request);
        $this->cashier = $request->getCashier();
        $this->invoiceNumber = $request->getInvoiceNumber();
        $this->dateAndTimeOfIssue = $request->getDateAndTimeOfIssue();
        $this->referentDocumentNumber = $request->getReferentDocumentNumber();
        $this->referentDocumentDateAndTime = $request->getReferentDocumentDateTime();
        $this->amount = $response->totalAmount();
        $this->items = $request->getItems();
        $this->payment = $request->getPayments();
        $this->taxItems = $response->taxItems();
        $this->taxAmount = $this->calculateTaxAmount($this->taxItems);
        $this->sdcDateTime = $response->sdcDateTime();
        $this->sdcInterfacesNumber = $response->invoiceNumber();
        $this->invoiceCounter = $response->invoiceCounter();
        $this->qrCode = $response->verificationQRCode();
    }


    /**
     * @param TaxItem[]|null $items
     * @return float
     */
    private function calculateTaxAmount(?array $items): float
    {
        if (empty($items)) {
            return 0.0000;
        }

        return array_reduce($items, function (?float $carry, TaxItem $item): float {
            $carry += round($item->amount(), 4);
            return $carry;
        });
    }

    /**
     * @return Configuration
     */
    public function getConfiguration(): Configuration
    {
        return $this->configuration;
    }

    /**
     * @return Buyer
     */
    public function getBuyer(): Buyer
    {
        return $this->buyer;
    }

    /**
     * @return Cashier
     */
    public function getCashier(): Cashier
    {
        return $this->cashier;
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

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return Payment[]
     */
    public function getPayment(): array
    {
        return $this->payment;
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
    public function getQrCode(): string
    {
        return $this->qrCode;
    }
}