<?php
declare(strict_types=1);

namespace TaxCore\Examples\Request;

use DateTime;
use DateTimeInterface;
use Exception;
use TaxCore\Entities\Request\RequestWithReferentDocumentPropertiesInterface;

final class RequestWithReferentDocumentProperties implements RequestWithReferentDocumentPropertiesInterface
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
     * @param string $referentDocumentDateTime
     * @throws Exception
     */
    public function __construct(string $referentDocumentNumber, string $referentDocumentDateTime)
    {
        $this->referentDocumentNumber = $referentDocumentNumber;
        $this->referentDocumentDateTime = new DateTime($referentDocumentDateTime);
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