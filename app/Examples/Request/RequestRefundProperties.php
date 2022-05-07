<?php
declare(strict_types=1);

namespace TaxCore\Examples\Request;

use DateTimeInterface;
use TaxCore\Entities\Request\RequestRefundPropertiesInterface;

final class RequestRefundProperties implements RequestRefundPropertiesInterface
{

    /**
     * @var string
     */
    protected string $referentDocumentNumber;

    /**
     * @var DateTimeInterface
     */
    protected DateTimeInterface $referentDocumentDateTime;

    /**
     * @param string $referentDocumentNumber
     * @param DateTimeInterface $referentDocumentDateTime
     */
    public function __construct(string $referentDocumentNumber, DateTimeInterface $referentDocumentDateTime)
    {
        $this->referentDocumentNumber = $referentDocumentNumber;
        $this->referentDocumentDateTime = $referentDocumentDateTime;
    }

    /**
     * @return array
     */
    public function items(): array
    {
        return include __DIR__ . '/../data/items.php';
    }

    /**
     * @return array
     */
    public function payment(): array
    {
        return include __DIR__ . '/../data/payment.php';
    }

    /**
     * @return string
     */
    public function referentDocumentNumber(): string
    {
        return $this->referentDocumentNumber;
    }

    /**
     * @return DateTimeInterface
     */
    public function referentDocumentDateTime(): DateTimeInterface
    {
        return $this->referentDocumentDateTime;
    }
}
