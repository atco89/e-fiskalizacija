<?php
declare(strict_types=1);

namespace TaxCore;

use DateTime;
use Exception;
use TaxCore\Entities\RequestInterface;
use TaxCore\Entities\Tax;

final class DocumentProperties
{

    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @var Tax[]
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
     * @param RequestInterface $request
     * @param Response $response
     * @throws Exception
     */
    public function __construct(RequestInterface $request, Response $response)
    {
        $this->request = $request;
        $this->taxItems = $response->taxItems();
        $this->taxAmount = $this->loadTaxAmount($this->taxItems);
        $this->sdcDateTime = $response->sdcDateTime();
        $this->sdcInterfacesNumber = $response->invoiceNumber();
        $this->invoiceCounter = $response->invoiceCounter();
        $this->verificationQRCode = $response->verificationQRCode();
    }

    /**
     * @param Tax[] $taxItems
     * @return float
     */
    private function loadTaxAmount(array $taxItems): float
    {
        if (empty($taxItems)) {
            return 0.0000;
        }

        return array_reduce($taxItems, function (?float $carry, Tax $item): float {
            $carry += $item->amount();
            return $carry;
        });
    }

    /**
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * @return Tax[]
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