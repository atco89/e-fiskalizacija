<?php
declare(strict_types=1);

namespace TaxCore\Request;

use DateTimeInterface;
use TaxCore\Entities\Enums\TransactionType;
use TaxCore\Entities\Properties\RequestRefundPropertiesInterface;
use TaxCore\Entities\ReferentDocumentInterface;

abstract class Refund extends RequestBase implements ReferentDocumentInterface
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
     * @param RequestRefundPropertiesInterface $properties
     */
    public function __construct(RequestRefundPropertiesInterface $properties)
    {
        parent::__construct($properties);
        $this->referentDocumentNumber = $properties->referentDocumentNumber();
        $this->referentDocumentDateTime = $properties->referentDocumentDateTime();
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

    /**
     * @return TransactionType
     */
    public function transactionType(): TransactionType
    {
        return TransactionType::REFUND;
    }
}
