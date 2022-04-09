<?php
declare(strict_types=1);

namespace Fiskalizacija;

use DateTime;
use Exception;
use Fiskalizacija\Interfaces\Invoice;

final class DocumentProperties
{

    /**
     * @var Invoice
     */
    private Invoice $invoice;

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
        $this->sdcDateTime = $response->sdcDateTime();
        $this->sdcInterfacesNumber = $response->invoiceNumber();
        $this->invoiceCounter = $response->invoiceCounter();
        $this->verificationQRCode = $response->verificationQRCode();
    }

    /**
     * @return Invoice
     */
    public function getInvoice(): Invoice
    {
        return $this->invoice;
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