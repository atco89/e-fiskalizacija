<?php
declare(strict_types=1);

namespace Fiskalizacija\Invoice;

use DateTime;
use Exception;
use Fiskalizacija\Entities\Item;
use Fiskalizacija\Entities\Merchant;
use Fiskalizacija\Entities\Payment;
use Fiskalizacija\Entities\TaxItem;
use Fiskalizacija\Sale\Request;
use Fiskalizacija\Sale\Response;

final class Properties
{

    /**
     * @var Merchant
     */
    private Merchant $merchant;

    /**
     * @var LegalEntityBuyer
     */
    private LegalEntityBuyer $buyer;

    /**
     * @var string
     */
    private string $cashier;

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
     * @param Merchant $merchant
     * @param Request $request
     * @param Response $response
     * @throws Exception
     */
    public function __construct(Merchant $merchant, Request $request, Response $response)
    {
        $this->merchant = $merchant;
        $this->buyer = new LegalEntityBuyer($request);
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
     * @param TaxItem[] $items
     * @return float
     */
    private function calculateTaxAmount(array $items): float
    {
        if (empty($items)) {
            return 0.00;
        }

        return array_reduce($items, function (?float $carry, TaxItem $item): float {
            $carry += $item->amount();
            return $carry;
        });
    }

    /**
     * @return Merchant
     */
    public function getMerchant(): Merchant
    {
        return $this->merchant;
    }

    /**
     * @return LegalEntityBuyer
     */
    public function getBuyer(): LegalEntityBuyer
    {
        return $this->buyer;
    }

    /**
     * @return string
     */
    public function getCashier(): string
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