<?php
declare(strict_types=1);

namespace TaxCore\Examples\Request;

use DateTime;
use DateTimeInterface;
use Exception;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;
use TaxCore\Entities\Request\RequestWithReferentDocumentPropertiesCustomerIdentifiedInterface;

final class RequestWithReferentDocumentCustomerIdentifiedProperties implements RequestWithReferentDocumentPropertiesCustomerIdentifiedInterface
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
     * @return ItemInterface[]
     */
    public function items(): array
    {
        return include __DIR__ . '/../data/items.php';
    }

    /**
     * @return PaymentTypeInterface[]
     */
    public function payment(): array
    {
        return include __DIR__ . '/../data/payment.php';
    }

    /**
     * @return string
     */
    public function buyerId(): string
    {
        return include __DIR__ . '/../data/buyer_id.php';
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