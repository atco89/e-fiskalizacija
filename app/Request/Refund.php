<?php
declare(strict_types=1);

namespace TaxCore\Request;

use DateTime;
use Exception;
use TaxCore\Entities\Enums\TransactionType;
use TaxCore\Entities\ReferentDocumentInterface;

abstract class Refund extends CommonRequest implements ReferentDocumentInterface
{

    /**
     * @var array
     */
    protected array $referentDocument;

    /**
     * @param string $cashier
     * @param array $items
     * @param array $payment
     * @param array $referentDocument
     */
    public function __construct(string $cashier, array $items, array $payment, array $referentDocument)
    {
        parent::__construct($cashier, $items, $payment);
        $this->referentDocument = $referentDocument;
    }

    /**
     * @return string
     */
    final public function referentDocumentNumber(): string
    {
        return $this->referentDocument['referentDocumentNumber'];
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    final public function referentDocumentDateTime(): DateTime
    {
        return new DateTime($this->referentDocument['referentDocumentDateTime']);
    }

    /**
     * @return TransactionType
     */
    final public function transactionType(): TransactionType
    {
        return TransactionType::REFUND;
    }
}
