<?php
declare(strict_types=1);

namespace TaxCore\Request\Copy;

use DateTime;
use Exception;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\ReferentDocumentInterface;
use TaxCore\Request\Sale;

final class CopySale extends Sale implements ReferentDocumentInterface
{

    /**
     * @var array
     */
    private array $referentDocument;

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
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return InvoiceType::COPY;
    }

    /**
     * @return string
     */
    public function referentDocumentNumber(): string
    {
        return $this->referentDocument['referentDocumentNumber'];
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function referentDocumentDateTime(): DateTime
    {
        return new DateTime($this->referentDocument['referentDocumentDateTime']);
    }
}
