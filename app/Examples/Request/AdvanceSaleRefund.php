<?php
declare(strict_types=1);

namespace TaxCore\Examples\Request;

use DateTimeInterface;
use Exception;
use TaxCore\Entities\AdvanceSaleItemInterface;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;
use TaxCore\Entities\Request\RequestWithReferentDocumentInterface;
use TaxCore\Response\Response;

final class AdvanceSaleRefund implements RequestWithReferentDocumentInterface
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
     * @param Response $response
     * @throws Exception
     */
    public function __construct(Response $response)
    {
        $this->referentDocumentNumber = $response->invoiceNumber();
        $this->referentDocumentDateTime = $response->sdcDateTime();
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
        return include __DIR__ . '/../data/advance-refund-payment.php';
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
     * @return AdvanceSaleItemInterface[]|null
     */
    public function advanceSaleItems(): array|null
    {
        return include __DIR__ . '/../data/advance-sale-items.php';
    }
}
