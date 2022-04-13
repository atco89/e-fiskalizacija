<?php
declare(strict_types=1);

namespace TaxCore;

use DateTime;
use Exception;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\Enums\TransactionType;
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
     * @var string
     */
    private string $title;

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
        $this->title = $this->loadTitle();
    }

    /**
     * @return string
     */
    private function loadTitle(): string
    {
        $invoiceType = $this->request->invoiceType();
        if ($this->request->transactionType() === TransactionType::SALE) {
            return match ($invoiceType) {
                InvoiceType::NORMAL   => 'Продаја',
                InvoiceType::PROFORMA => 'Проформа',
                InvoiceType::COPY     => 'Копија',
                InvoiceType::TRAINING => 'Обука',
                InvoiceType::ADVANCE  => 'Авансни рачун',
            };
        }
        return match ($invoiceType) {
            InvoiceType::NORMAL   => 'Продаја - Повраћај',
            InvoiceType::PROFORMA => 'Проформа - Повраћај',
            InvoiceType::COPY     => 'Копија - Повраћај',
            InvoiceType::TRAINING => 'Обука - Повраћај',
            InvoiceType::ADVANCE  => 'Авансни рачун - Повраћај',
        };
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

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}