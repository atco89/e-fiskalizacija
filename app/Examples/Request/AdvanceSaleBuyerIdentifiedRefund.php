<?php
declare(strict_types=1);

namespace TaxCore\Examples\Request;

use DateTimeInterface;
use Exception;
use TaxCore\Entities\AdvanceSaleItem;
use TaxCore\Entities\ItemInterface;
use TaxCore\Entities\PaymentTypeInterface;
use TaxCore\Entities\Request\RequestWithReferentDocumentBuyerIdentifiedInterface;
use TaxCore\Response\Response;

final class AdvanceSaleBuyerIdentifiedRefund implements RequestWithReferentDocumentBuyerIdentifiedInterface
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
    public function buyerId(): string
    {
        return include __DIR__ . '/../data/buyer-id.php';
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
     * @return AdvanceSaleItem[]|null
     */
    public function advanceSaleItems(): array|null
    {
        return include __DIR__ . '/../data/advance-sale-items.php';
    }
}
