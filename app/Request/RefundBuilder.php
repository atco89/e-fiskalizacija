<?php
declare(strict_types=1);

namespace TaxCore\Request;

use DateTimeInterface;
use TaxCore\Entities\Enums\TransactionType;
use TaxCore\Entities\ReferentDocumentInterface;
use TaxCore\Entities\Request\RequestInterface;
use TaxCore\Entities\Request\RequestWithReferentDocumentInterface;

abstract class RefundBuilder extends ApiRequestBase implements ReferentDocumentInterface
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
     * @param RequestWithReferentDocumentInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        parent::__construct($request);
        $this->referentDocumentNumber = $request->referentDocumentNumber();
        $this->referentDocumentDateTime = $request->referentDocumentDateTime();
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
